<?php

namespace ImportSystem\Fleet\Domain;

final class FleetExcelColumns
{
    private static array $columns = [
        [
            "id" => "vin",
            "name" => "Bastidor",
            "dataType" => "string",
            "required" => true,
            "dropdown" => false,
        ],
        [
            "id" => "licensePlate",
            "name" => "Matrícula",
            "dataType" => "string",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "anexo1Year",
            "name" => "Año del anexo1",
            "dataType" => "int",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "anexo1IntRef",
            "name" => "Referencia interna del anexo1",
            "dataType" => "string",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "modelcode",
            "name" => "ModelCode",
            "dataType" => "string",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "providerSAPId",
            "name" => "Proveedor de compra",
            "dataType" => "int",
            "required" => true,
            "dropdown" => true,
            "findBy" => "providerSAPId",
        ],
        [
            "id" => "saleMethod",
            "name" => "Método de venta",
            "dataType" => "int",
            "required" => true,
            "dropdown" => true,
            "findBy" => "name",
        ],
        [
            "id" => "purchaseType",
            "name" => "Tipo de compra",
            "dataType" => "int",
            "required" => true,
            "dropdown" => true,
            "findBy" => "name",
        ],
        [
            "id" => "customerSAPId",
            "name" => "Proveedor de recompra",
            "dataType" => "int",
            "required" => false,
            "dropdown" => true,
            "findBy" => "customerSAPId",
        ],
        [
            "id" => "vehicleSalesName",
            "name" => "Nombre comercial",
            "dataType" => "string",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "brand",
            "name" => "Marca",
            "dataType" => "string",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "model",
            "name" => "Modelo",
            "dataType" => "string",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "trim",
            "name" => "Acabado",
            "dataType" => "string",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "trimId",
            "name" => "Código acabado",
            "dataType" => "int",
            "required" => true,
            "dropdown" => true,
            "findBy" => "id",
        ],
        [
            "id" => "carCC",
            "name" => "Cilindrada",
            "dataType" => "int",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "cv",
            "name" => "CV",
            "dataType" => "float",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "motorizationType",
            "name" => "Tipo de combustible",
            "dataType" => "int",
            "required" => true,
            "dropdown" => true,
            "findBy" => "name",
        ],
        [
            "id" => "motor",
            "name" => "Motor",
            "dataType" => "float",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "motorDenomination",
            "name" => "Denominación motor",
            "dataType" => "string",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "kw",
            "name" => "KW",
            "dataType" => "float",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "gearBox",
            "name" => "Caja de cambios",
            "dataType" => "string",
            "required" => true,
            "dropdown" => true,
            "findBy" => "name",
        ],
        [
            "id" => "color",
            "name" => "Color",
            "dataType" => "string",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "colorMIR",
            "name" => "Color MIR",
            "dataType" => "int",
            "required" => false,
            "dropdown" => true,
            "findBy" => "name",
        ],
        [
            "id" => "co2",
            "name" => "CO2",
            "dataType" => "float",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "numberOfDoors",
            "name" => "Nº puertas",
            "dataType" => "int",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "vehicleSeats",
            "name" => "Nº plazas",
            "dataType" => "int",
            "required" => false,
            "dropdown" => true,
            "findBy" => "value",
        ],
        [
            "id" => "tankCapacity",
            "name" => "Capacidad depósito",
            "dataType" => "float",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "trunkCapacity",
            "name" => "Volumen maletero",
            "dataType" => "int",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "batteryCapacity",
            "name" => "Capacidad batería",
            "dataType" => "float",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "height",
            "name" => "Alto",
            "dataType" => "int",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "interiorHeight",
            "name" => "Alto interior",
            "dataType" => "int",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "width",
            "name" => "Ancho",
            "dataType" => "int",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "interiorWidth",
            "name" => "Ancho interior",
            "dataType" => "int",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "length",
            "name" => "Largo",
            "dataType" => "int",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "interiorLength",
            "name" => "Largo interior",
            "dataType" => "int",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "nive",
            "name" => "NIVE",
            "dataType" => "string",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "firstRegistrationDate",
            "name" => "F. matriculación",
            "dataType" => "date",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "lastRegistrationDate",
            "name" => "F. última matriculación",
            "dataType" => "date",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "vehicleGroup",
            "name" => "Grupo",
            "dataType" => "int",
            "required" => false,
            "dropdown" => true,
            "findBy" => "name",
        ],
        [
            "id" => "vehicleType",
            "name" => "Tipo de vehículo",
            "dataType" => "int",
            "required" => true,
            "dropdown" => true,
            "findBy" => "name",
        ],
        [
            "id" => "acriss",
            "name" => "ACRISS",
            "dataType" => "int",
            "required" => true,
            "dropdown" => true,
            "findBy" => "name",
        ],
        [
            "id" => "averageDamageAmount",
            "name" => "Promedio daños",
            "dataType" => "float",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "initialKms",
            "name" => "KM inicial",
            "dataType" => "int",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "deliveryDate",
            "name" => "F. recepción",
            "dataType" => "date",
            "required" => true,
            "dropdown" => false,
        ],
        [
            "id" => "firstRentDate",
            "name" => "F. ini alquiler",
            "dataType" => "date",
            "required" => true,
            "dropdown" => false,
        ],
        [
            "id" => "rentingEndDate",
            "name" => "F. fin alquiler",
            "dataType" => "date",
            "required" => true,
            "dropdown" => false,
        ],
        [
            "id" => "returnDate",
            "name" => "F. devolución",
            "dataType" => "date",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "receptionLocation",
            "name" => "Localización de recepción",
            "dataType" => "int",
            "required" => false,
            "dropdown" => true,
            "findBy" => "name",
        ],
        [
            "id" => "actualLocation",
            "name" => "Localización actual",
            "dataType" => "int",
            "required" => false,
            "dropdown" => true,
            "findBy" => "name",
        ],
        [
            "id" => "forfait",
            "name" => "Forfait",
            "dataType" => "float",
            "required" => false,
            "dropdown" => false,
        ],

        [
            "id" => "excess",
            "name" => "Franquicia",
            "dataType" => "float",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "holdingPeriod",
            "name" => "Meses de permanencia",
            "dataType" => "int",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "depreciationPerAmount",
            "name" => "% Depreciación",
            "dataType" => "float",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "depreciationMonths",
            "name" => "Meses depreciación",
            "dataType" => "int",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "vehicleStatus",
            "name" => "Estado del vehículo",
            "dataType" => "int",
            "required" => true,
            "dropdown" => true,
            "findBy" => "name",
            "default" => "CARSTATUS_NEW_VIN",
        ],
        [
            "id" => "actualKms",
            "name" => "KM actual",
            "dataType" => "int",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "insurancePolicyProviderSAPId",
            "name" => "Proveedor seguro",
            "dataType" => "int",
            "required" => false,
            "dropdown" => true,
            "findBy" => "providerSAPId",
        ],
        [
            "id" => "policyNumber",
            "name" => "Nº póliza",
            "dataType" => "string",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "activationDate",
            "name" => "F. alta seguro",
            "dataType" => "date",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "cancelationDate",
            "name" => "F. baja seguro",
            "dataType" => "date",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "finishDate",
            "name" => "F. vencimiento seguro",
            "dataType" => "date",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "minHoldingPeriodAmount",
            "name" => "Meses mínimo tenencia",
            "dataType" => "int",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "minHoldingPeriodKm",
            "name" => "KM min tenencia",
            "dataType" => "int",
            "required" => false,
            "dropdown" => false,
        ],

        [
            "id" => "pffAmount",
            "name" => "PFF",
            "dataType" => "float",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "optionsAmount",
            "name" => "Precio opciones",
            "dataType" => "float",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "purchaseDiscount",
            "name" => "Descuento",
            "dataType" => "float",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "transportAmount",
            "name" => "Precio transporte",
            "dataType" => "float",
            "required" => false,
            "dropdown" => false,
        ],
        [
            "id" => "netAmount",
            "name" => "Neto",
            "dataType" => "float",
            "required" => true,
            "dropdown" => false,
        ],
        // FIXME colocar como obligatoria una vez WS nos devuelva el campo
        [
            "id" => "creationDate",
            "name" => "F. introducción",
            "dataType" => "date",
            "required" => false,
            "dropdown" => false,
        ],


        // Campos suprimidos
        // [
        //     "id" => "averageRegistrationDate",
        //     "name" => "Promedio fecha matriculación",
        //     "dataType" => "date",
        //     "required" => false,
        //     "dropdown" => false,
        // ],
        // [
        //     "id" => "monthlyFee",
        //     "name" => "Cuota mensual (renting)",
        //     "dataType" => "float",
        //     "required" => false,
        //     "dropdown" => false,
        // ],
        // [
        //     "id" => "invoiceNumber",
        //     "name" => "Numero factura proveedor",
        //     "dataType" => "string",
        //     "required" => false,
        //     "dropdown" => false,
        // ],
        // [
        //     "id" => "invoiceDate",
        //     "name" => "Fecha del documento (fecha factura)",
        //     "dataType" => "date",
        //     "required" => false,
        //     "dropdown" => false,
        // ],
        // [
        //     "id" => "invoiceAmountWhitoutVat",
        //     "name" => "Importe de factura",
        //     "dataType" => "float",
        //     "required" => false,
        //     "dropdown" => false,
        // ],
        // [
        //     "id" => "accountingDate",
        //     "name" => "Fecha contable",
        //     "dataType" => "date",
        //     "required" => false,
        //     "dropdown" => false,
        // ],
        // [
        //     "id" => "capAmount",
        //     "name" => "Importe CAP",
        //     "dataType" => "float",
        //     "required" => false,
        //     "dropdown" => false,
        // ],
        // [
        //     "id" => "taxUnitAmount",
        //     "name" => "Tasas",
        //     "dataType" => "float",
        //     "required" => false,
        //     "dropdown" => false,
        // ],
        // [
        //     "id" => "fixedAssetRegistrationDate",
        //     "name" => "Fecha de alta de activo fijo",
        //     "dataType" => "date",
        //     "required" => false,
        //     "dropdown" => false,
        // ],
        // [
        //     "id" => "fixedAssetClass",
        //     "name" => "Clase de activo fijo",
        //     "dataType" => "string",
        //     "required" => false,
        //     "dropdown" => false,
        // ],
        // [
        //     "id" => "amortizationStartDate",
        //     "name" => "Fecha de inicio de amortización",
        //     "dataType" => "date",
        //     "required" => false,
        //     "dropdown" => false,
        // ],
        // [
        //     "id" => "amortizationClass",
        //     "name" => "Clase de amortización",
        //     "dataType" => "string",
        //     "required" => false,
        //     "dropdown" => false,
        // ],
        // [
        //     "id" => "financingType",
        //     "name" => "Tipo de financiación",
        //     "dataType" => "string",
        //     "required" => false,
        //     "dropdown" => false,
        // ],
        // [
        //     "id" => "fromThirdParties",
        //     "name" => "De terceros",
        //     "dataType" => "string",
        //     "required" => false,
        //     "dropdown" => false,
        // ],
        // [
        //     "id" => "leasePercentage",
        //     "name" => "% Arrendamiento",
        //     "dataType" => "float",
        //     "required" => false,
        //     "dropdown" => false,
        // ],
        // [
        //     "id" => "repurchaseMonths",
        //     "name" => "Meses para la recompra",
        //     "dataType" => "int",
        //     "required" => false,
        //     "dropdown" => false,
        // ],
        // [
        //     "id" => "businessUnit",
        //     "name" => "Unidad de negocio",
        //     "dataType" => "string",
        //     "required" => false,
        //     "dropdown" => false,
        // ],
        // [
        //     "id" => "area",
        //     "name" => "Área",
        //     "dataType" => "string",
        //     "required" => false,
        //     "dropdown" => false,
        // ],
        // [
        //     "id" => "provisionGenerates",
        //     "name" => "¿Genera provisión?",
        //     "dataType" => "string",
        //     "required" => false,
        //     "dropdown" => false,
        // ],
    ];

    public static function keyExists(string $key): bool
    {
        return array_search($key, array_column(self::$columns, 'id')) !== false;
    }

    public static function nameExists(string $name): bool
    {
        return array_search($name, array_column(self::$columns, 'name')) !== false;
    }

    public static function nameLike(string $name): ?array
    {
        $nameWords = explode(' ', $name);
        $nameWords = preg_split('/([\s%=$]+)/', $name, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        $bestMatch = null;
        $bestMatchCount = 0;

        foreach (self::$columns as $column) {
            $columnWords = explode(' ', $column['name']);
            $matchCount = count(array_intersect($nameWords, $columnWords));

            if ($matchCount > $bestMatchCount) {
                $bestMatchCount = $matchCount;
                $bestMatch = $column;
            }
        }

        return $bestMatch;
    }

    /**
     * @param string ...$excludeIdsLike excluye aquellas columnas cuyo id contenga alguna de las cadenas proporcionadas
     * @return array
     */
    public static function getColumns(string ...$excludeIdsLike): array
    {
        if (!empty($excludeIdsLike)) {
            $columnsNotExcluded = [];
            // INFO: Si se utiliza array_filter, $this->json lo devuelve como objeto con índice 0 en lugar de array
            foreach (self::$columns as $col) {
                $exclude = false;
                foreach ($excludeIdsLike as $excludeId) {
                    if (str_contains($col['id'], $excludeId)) {
                        $exclude = true;
                        break;
                    }
                }
                if (!$exclude) {
                    $columnsNotExcluded[] = $col;
                }
            }
            return $columnsNotExcluded;
        }

        return self::$columns;
    }

    /**
     * @param string $columnName
     * @return array|null
     */
    public static function getByName(string $columnName): ?array
    {
        return self::nameExists($columnName) ? self::$columns[array_search($columnName, array_column(self::$columns, 'name'))] : null;
    }

    /**
     * @param string $columnId
     * @return array|null
     */
    public static function getById(string $columnId): ?array
    {
        return self::keyExists($columnId) ? self::$columns[array_search($columnId, array_column(self::$columns, 'id'))] : null;
    }

    /**
     * @param string $columnId
     * @return string|null
     */
    public static function getNameById(string $columnId): ?string
    {
        return self::keyExists($columnId) ? self::$columns[array_search($columnId, array_column(self::$columns, 'id'))]['name'] : null;
    }

    /**
     * @return array
     */
    public static function getAllColumns(): array
    {
        return self::$columns;
    }
}
