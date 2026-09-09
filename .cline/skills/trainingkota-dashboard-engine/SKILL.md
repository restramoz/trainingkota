# Skill: trainingkota-dashboard-engine

## Context
Triggered when building admin dashboards, statistics views, or reporting tools.

## Implementation Steps
1. **Aggregation**: Use Eloquent `count()`, `sum()`, etc., to fetch real data.
2. **Visualization**: Implement charts or summary cards using `admin.layout`.
3. **Filtering**: Add date range or category filters to stats.
4. **Performance**: Use caching for heavy aggregation queries.

## Constraints
- NO fake statistics.
- NO hardcoded numbers.
- Must use the dark mode palette.
