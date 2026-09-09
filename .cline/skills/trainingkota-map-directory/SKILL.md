# Skill: trainingkota-map-directory

## Context
Triggered when implementing the map-based directory or location listings.

## Implementation Steps
1. **Data Fetching**: Retrieve coordinates and addresses from the `locations` table.
2. **Map Integration**: Implement JS map (Google/Leaflet) using DB coordinates.
3. **Filtering**: Allow filtering by city/service.
4. **Detail View**: Link map markers to detailed location pages.

## Constraints
- DO NOT fabricate coordinates or addresses.
- Use existing `cities` (212) and `locations` records.
