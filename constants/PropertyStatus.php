<?php

namespace app\constants;

enum PropertyStatus: int
{
    case SoilPreparation = 1;
    case Planting = 2;
    case PlantationMaintenance = 3;
    case Harvesting = 4;

    /**
     * @return array where the key is the enum value and the array value is the enum name
     * 
     * ToDo: this needs improvement, it assumes enum keys start at 1 and are sequencial
     */
    public static function getValuesWithNames (): array
    {
        $enumCases = PropertyStatus::cases();

        // re-index, cases keys start at 0
        return array_combine(range(1, count($enumCases)), array_values($enumCases));
    }
}
