<?php
use HLC\AP\Views\Helpers\ComponentsHelper;
?>
<div class="modal fade" id="addTask" tabindex="-1" role="dialog" aria-labelledby="addTaskLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form action="/task/save" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskLabel">Nueva tarea</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input required class="au-input au-input--full" type="text" name="name"
                               placeholder="nombre">
                    </div>
                    <div class="form-group">
                        <label>Descipcion</label>
                        <input required class="au-input au-input--full" type="text" name="desc"
                               placeholder="descripcion">
                    </div>
                    <div class="form-group">
                        <label>Fecha inicio</label>
                        <input class="au-input au-input--full" type="date"
                               name="startDate"
                               placeholder="dd/mm/yyyy">
                    </div>
                    <div class="form-group">
                        <label>Fecha fin</label>
                        <input class="au-input au-input--full" type="date"
                               name="endDate"
                               placeholder="dd/mm/yyyy">
                    </div>
                    <div class="form-group">
                        <div>
                            <label for="subjectId" class=" form-control-label">Asignatura</label>
                        </div>
                        <div>
                                <?=
                                ComponentsHelper::selectorBuilder(
                                    "subjectId",
                                    "subjectId",
                                    $this->subjectNames,
                                    ["getId", "getName"]
                                );
                                ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="save" class="au-btn au-btn--green">Añadir</button>
                </div>
            </form>
        </div>
    </div>
</div>