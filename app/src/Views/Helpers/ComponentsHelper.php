<?php

namespace HLC\AP\Views\Helpers;

class ComponentsHelper
{
    /**
     * @param string $name - Nombre del selector
     * @param string $id - Identificador del selector
     * @param array $list - Lista de aquello que queremos generar el selector
     * @param string[] $keys - Elementos que extraemos para mostrar en el selector [0] = codigo, [1] = descripcion
     * @param string|null $selected - Elemento que debe venir seleccionado por defecto si existiese
     * @param bool $readOnly - Selector de solo lectura
     * @return string - HTML del selector generado
     */
    public static function selectorBuilder(
        string $name,
        string $id,
        array $list,
        array $keys,
        ?string $selected = null,
        bool $readOnly = false
    ): string {
        $selector = "<select name=\"{$name}\" id=\"{$id}\" class=\"form-control\"";
        if ($readOnly) {
            $selector .= " readonly";
        }
        $selector .= ">";

        $selector .= "<option value=\"0\"> Select an option </option>";
        foreach ($list as $value) {
            $aux1 = $keys[0];
            $aux2 = $keys[1];
            $data1 = $value->$aux1();
            $data2 = $value->$aux2();
            $selector .= "<option value=\"$data1\"";
            if ($selected === $data1) {
                $selector .= " selected";
            }
            $selector .= "> $data2 </option>";
        }

        $selector .= "</select>";
        return $selector;
    }
}
