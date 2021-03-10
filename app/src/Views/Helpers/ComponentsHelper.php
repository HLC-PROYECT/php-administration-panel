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
    ): string
    {

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
     * @param array $list - Lista de aquello que queremos generar la tabla
     * @param array $keys - Array con las columnas de la tabla
     * @param array $buttons - Array con los botones de acción para cada elemento.
     * @return string - HTML del selector generado
     */
    public static function tableBuilder(
        array $headers,
        array $list,
        array $keys,
        array $buttons,
    ): string {
        $table = "<table class='table table-data2' id='tabla'>";
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
            $id = $keys[0];
            $id = (string)$domain->$id();
            foreach ($keys as $propertyMethod) {
                $table .= '<td>' . $domain->$propertyMethod() . '</td>';
            }
            //Print actions buttons.
            $table .= '<td>';
            $table .= '<div class="table-data-feature">';
            foreach ($buttons as $button) {
                $title = $button['title'];
                $onclick = $button['onclick'];
                $iconClass = $button['iconClass'];
                $name = $button['name'];

                $table .= "<button class='item' 
                            data-toggle='tooltip' 
                            data-placement='top' 
                            title='$title' 
                            name='$name' 
                                onclick='$onclick($id)'>";

                $table .= "<i class='zmdi $iconClass' ></i >";
                $table .= '</button>';
            }
            $table .= '</div>';
            $table .= '</td >';
            $table .= '<tr class="spacer" >   </tr >';
        }

        $table .= '</table>';
        return $table;
    }

    //VICTOR: he tenido que crear uno a parte porque tiene bastante modificacion

    /**
     * @param array $headers - Cabeceras de la tabla
     * @param array $list - Lista de aquello que queremos generar la tabla
     * @param array $keys - Array con las columnas de la tabla
     * @param array $buttons - Array con los botones de acción para cada elemento.
     * @return string - HTML del selector generado
     */
    public static function tableBuilderForTasks(
        array $headers,
        array $list,
        array $keys,
        array $buttons,
        bool $isTeacher
    ): string
    {
        $table = "<table class='table table-data2' id='tabla'>";
        $table .= "<thead>";
        $table .= "<tr>";

        //Print headers
        foreach ($headers as $value) {
            $table .= "<th>" . $value . "</th>";
        }
        $table .= "</tr>";
        $table .= "</thead>";

        //Print rows
        foreach ($list as $domainSubject) {
            foreach ($domainSubject->getTasks() as $domain) {
                $table .= '<tr class="tr-shadow">';
                $id = $keys[0];
                $id = (string)$domain->$id();
                foreach ($keys as $index => $propertyMethod) {
                    if (count($keys) != ($index + 1)) $table .= '<td>' . $domain->$propertyMethod() . '</td>';
                    else $table .= '<td>' . $domainSubject->$propertyMethod() . '</td>';
                }
                //Print actions buttons.
                $table .= '<td>';
                $table .= '<div class="table-data-feature">';
                if ($domain->getStatus() != '1')
                foreach ($buttons as $button) {
                    $title = $button['title'];
                    $onclick = $button['onclick'];
                    $iconClass = $button['iconClass'];
                    $name = $button['name'];

                    $table .= "<button class='item' 
                            data-toggle='tooltip' 
                            data-placement='top' 
                            title='$title' 
                            name='$name' 
                            onclick='$onclick($id)'>";

                    $table .= "<i class='zmdi $iconClass' ></i >";
                    $table .= '</button>';
                }
                $table .= '</div>';
                $table .= '</td >';
                $table .= '<tr class="spacer" >   </tr >';
            }
        }

        $table .= '</table>';
        return $table;
    }
    /**
     * @param string name - Nombre descriptivo que aparece en el alert.
     * @param string $type - Tipo de alert que se desea hacer. [info, success, warning, error].
     * @return string - HTML del alert generado.
     */
    public static function emptyViewBuilder(string $name,string $type): string{

        return "<div class='alert alert-$type' role='alert'>There are no $name yet. To add one, click the add button at the top.</div>";
    }

}
