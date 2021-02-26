<?php

namespace HLC\AP\Views\Helpers;

class componentsHelper
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

    /**
     * @param array $headers - Cabeceras de la tabla
     * @param array $list - Lista de aquello que queremos generar el selector
     * @param array $keys - Array con las columnas de la tabla
     * @return string - HTML del selector generado
     */
    public static function tableBuilder(
        array $headers,
        array $list,
        array $keys
    ): string {
        $table = "<table class='table table-data2'>";
        $table .= "<thead>";
        $table .= "<tr>";

        //Print headers
        foreach ($headers as $value) {
            $table .= "<th>" . $value . "</th>";
        }
        $table .= "</tr>";
        $table .= "</thead>";

        //Print rows
        foreach ($list as $domain) {
            $table .= '<tr class="tr-shadow">';
            $id =  $keys[0];
            $id = (string) $domain->$id();
            foreach ($keys as $propertyMethod) {
                $table .= '<td>' . $domain->$propertyMethod() . '</td>';
            }
            //Print delete button.
            $table .= '<td>';
            $table .= '<div class="table-data-feature">';
            $table .= "<div class='item data-toggle='tooltip' onclick='remove($id)' ></div>";
            $table .= '<i class="zmdi zmdi-delete" ></i >';
            $table .= '</div>';
            $table .= '</td >';
            $table .= '<tr class="spacer" >   </tr >';
        }

        $table .= '</table>';
        return $table;
    }
}
