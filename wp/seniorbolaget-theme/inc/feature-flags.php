<?php
/**
 * Feature flags — aktivera/avaktivera funktioner utan att ta bort kod.
 * Sätt till true när backend/integration är redo.
 */

// Postnummerfält i hero — kräver pris-API integration
define('SENIORBOLAGET_FEATURE_POSTNUMMER', false);
