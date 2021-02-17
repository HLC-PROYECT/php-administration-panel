
<!-- PENDIENTE DE EDITAR -->

<div class="modal fade" id="addTask" tabindex="-1" role="dialog" aria-labelledby="addTaskLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form action="addTask.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskLabel">Nueva asignatura</h5>
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
                        <input class="au-input au-input--full" type="text" name="descripcion"
                               placeholder="descripcion">
                    </div>
                    <div class="form-group">
                        <label>Fecha inicio</label>
                        <input class="au-input au-input--full" id="finicio" type="date"
                               name="finicio"
                               placeholder="dd/mm/yyyy">
                    </div>
                    <div class="form-group">
                        <label>Fecha fin</label>
                        <input class="au-input au-input--full" id="ffin" type="date"
                               name="ffin"
                               placeholder="dd/mm/yyyy">
                    </div>
                    <div class="form-group">
                        <div>
                            <label for="select" class=" form-control-label">Curso</label>
                        </div>
                        <div>
                            <select name="select" id="select" class="form-control">
                                <?php

                                foreach ($course as $key => $value) {
                                    echo '<option value="' . $key . '">' . $asignatura[$key]["curso"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="au-btn au-btn--green">Añadir</button>
                </div>
            </form>
        </div>
    </div>
</div>