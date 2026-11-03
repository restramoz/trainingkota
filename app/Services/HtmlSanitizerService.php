<?php

namespace App\Services;

use DOMDocument;
use DOMElement;
use DOMNode;

class HtmlSanitizerService
{
    /**
     * Allowed HTML tags in articles.
     *
     * @var array<string, bool>
     */
    protected array $allowedTags = [
        'p' => true,
        'h1' => true,
        'h2' => true,
        'h3' => true,
        'h4' => true,
        'h5' => true,
        'h6' => true,
        'ul' => true,
        'ol' => true,
        'li' => true,
        'strong' => true,
        'b' => true,
        'em' => true,
        'i' => true,
        'u' => true,
        's' => true,
        'del' => true,
        'blockquote' => true,
        'table' => true,
        'thead' => true,
        'tbody' => true,
        'tfoot' => true,
        'tr' => true,
        'th' => true,
        'td' => true,
        'a' => true,
        'hr' => true,
        'br' => true,
        'img' => true,
        'span' => true,
        'div' => true,
        'figure' => true,
        'figcaption' => true,
        'code' => true,
        'pre' => true,
        'sub' => true,
        'sup' => true,
    ];

    /**
     * Allowed attributes per tag.
     *
     * @var array<string, array<string, bool>>
     */
    protected array $allowedAttributes = [
        '*' => [
            'class' => true,
            'title' => true,
            'id' => true,
        ],
        'a' => [
            'href' => true,
            'target' => true,
            'rel' => true,
            'title' => true,
        ],
        'img' => [
            'src' => true,
            'alt' => true,
            'title' => true,
            'width' => true,
            'height' => true,
            'loading' => true,
        ],
        'th' => [
            'colspan' => true,
            'rowspan' => true,
            'scope' => true,
        ],
        'td' => [
            'colspan' => true,
            'rowspan' => true,
        ],
    ];

    /**
     * Sanitize HTML content.
     */
    public function sanitize(?string $html): string
    {
        if ($html === null || trim($html) === '') {
            return '';
        }

        $dom = new DOMDocument('1.0', 'UTF-8');
        $prevErrors = libxml_use_internal_errors(true);

        // Wrap with a root container and UTF-8 meta
        $wrapped = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body><div id="sanitizer-root">'.$html.'</div></body></html>';
        $dom->loadHTML($wrapped, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($prevErrors);

        $root = $dom->getElementById('sanitizer-root');
        if (! $root) {
            return '';
        }

        $this->cleanNode($root);

        // Serialize inner HTML of sanitizer-root
        $cleanHtml = '';
        foreach ($root->childNodes as $child) {
            $cleanHtml .= $dom->saveHTML($child);
        }

        // Remove format-artifact empty square brackets that leaked into text.
        $cleanHtml = preg_replace('/\[\s*\]/u', '', $cleanHtml) ?? $cleanHtml;

        // Remove HTML tags that leaked as escaped text (artifact), e.g. &lt;script&gt;.
        $cleanHtml = preg_replace('/&lt;\/?[a-zA-Z][^&]{0,200}&gt;/u', '', $cleanHtml) ?? $cleanHtml;

        return trim($cleanHtml);
    }

    /**
     * Recursively clean DOM node.
     */
    protected function cleanNode(DOMNode $node): void
    {
        // Work on a copy of child nodes since modifying the DOM during iteration can skip elements
        $children = [];
        foreach ($node->childNodes as $child) {
            $children[] = $child;
        }

        foreach ($children as $child) {
            if ($child instanceof DOMElement) {
                $tagName = strtolower($child->tagName);

                // If tag is not allowed, either unwrap or remove
                if (! isset($this->allowedTags[$tagName])) {
                    // Dangerous tags like script, style, iframe, object, embed, svg, form are purged completely
                    $dangerousTags = ['script', 'style', 'iframe', 'frame', 'object', 'embed', 'applet', 'svg', 'math', 'form', 'input', 'button', 'textarea', 'select', 'link', 'meta', 'base'];
                    if (in_array($tagName, $dangerousTags, true)) {
                        $node->removeChild($child);

                        continue;
                    }

                    // For non-dangerous unauthorized tags, unwrap text/children
                    while ($child->firstChild) {
                        $node->insertBefore($child->firstChild, $child);
                    }
                    $node->removeChild($child);

                    continue;
                }

                // Tag is allowed: clean attributes
                $this->cleanAttributes($child);

                // Recursively clean children
                $this->cleanNode($child);
            }
        }
    }

    /**
     * Clean and filter element attributes against allowlist.
     */
    protected function cleanAttributes(DOMElement $element): void
    {
        $tagName = strtolower($element->tagName);
        $attributesToRemove = [];

        foreach ($element->attributes as $attr) {
            $attrName = strtolower($attr->nodeName);
            $attrValue = trim($attr->nodeValue);

            // 1. Immediately drop any event handler (on*)
            if (str_starts_with($attrName, 'on')) {
                $attributesToRemove[] = $attrName;

                continue;
            }

            // 2. Check if attribute is in allowlist for this tag or global '*'
            $isAllowed = isset($this->allowedAttributes[$tagName][$attrName])
                || isset($this->allowedAttributes['*'][$attrName]);

            if (! $isAllowed) {
                $attributesToRemove[] = $attrName;

                continue;
            }

            // 3. Strict URL validation for href and src
            if ($attrName === 'href' || $attrName === 'src') {
                if (! $this->isValidUrl($attrValue, $attrName === 'src')) {
                    $attributesToRemove[] = $attrName;

                    continue;
                }
            }

            // 4. Extra safety for target="_blank"
            if ($tagName === 'a' && $attrName === 'target' && strtolower($attrValue) === '_blank') {
                $element->setAttribute('rel', 'noopener noreferrer');
            }
        }

        foreach ($attributesToRemove as $attrName) {
            $element->removeAttribute($attrName);
        }
    }

    /**
     * Validate URL scheme and safety.
     */
    protected function isValidUrl(string $url, bool $isImage = false): bool
    {
        $url = trim($url);

        if ($url === '') {
            return false;
        }

        // Prevent control chars and line breaks
        if (preg_match('/[\x00-\x1F\x7F]/', $url)) {
            return false;
        }

        // Relative URLs starting with '/' or '#' are permitted (except protocol-relative '//')
        if (str_starts_with($url, '/') && ! str_starts_with($url, '//')) {
            return true;
        }

        if (! $isImage && str_starts_with($url, '#')) {
            return true;
        }

        // Check scheme
        $parsed = parse_url($url);
        if (! $parsed || ! isset($parsed['scheme'])) {
            return false;
        }

        $scheme = strtolower($parsed['scheme']);

        if ($isImage) {
            // Images must be http or https
            return in_array($scheme, ['http', 'https'], true);
        }

        // Links can be http, https, mailto, tel
        return in_array($scheme, ['http', 'https', 'mailto', 'tel'], true);
    }
}
