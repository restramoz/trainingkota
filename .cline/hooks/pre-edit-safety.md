# Pre-Edit Safety Hook

## Objective
Prevent catastrophic data loss or architectural drift before any file modification.

## Check-list
1. **Backup Check**: Is there a recent database backup?
2. **Protected Data**: Does this edit touch `cities`, `services`, or `locations` records? (If yes, STOP).
3. **Command Check**: Am I about to run `migrate:fresh` or `migrate:refresh`? (If yes, STOP).
4. **Hardcoding Check**: Am I adding a phone number or address directly to a view? (If yes, use `config('contact.phone')` or DB).
5. **AI Safety**: Is this content being set to `status = 'published'` automatically? (If yes, change to `draft`).
