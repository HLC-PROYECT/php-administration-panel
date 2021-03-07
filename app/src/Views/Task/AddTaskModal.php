<?php

use HLC\AP\Views\Helpers\ComponentsHelper;

?>
<div class="modal fade" id="addTask" tabindex="-1" role="dialog" aria-labelledby="addTaskLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form action="/task/save" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskLabel">New task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input required class="au-input au-input--full"
                               type="text"
                               name="name"
                               id="form_name"
                               placeholder="nombre">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input required class="au-input au-input--full"
                               type="text"
                               name="desc"
                               id="form_description"
                               placeholder="descripcion">
                    </div>
                    <div class="form-group">
                        <label>Start date</label>
                        <input class="au-input au-input--full"
                               type="date"
                               name="startDate"
                               id="form_startDate"
                               placeholder="dd/mm/yyyy">
                    </div>
                    <div class="form-group">
                        <label>End date</label>
                        <input class="au-input au-input--full"
                               type="date"
                               name="endDate"
                               id="form_endDate"
                               placeholder="dd/mm/yyyy">
                    </div>
                    <input class="au-input au-input--full"
                           id="form_taskId"
                           type="hidden"
                           value="0"
                           name="taskId"
                           placeholder="Description">
                    <div class="form-group">

                        <div>
                            <label for="subjectId" class=" form-control-label">Subject</label>
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
                    <button type="submit" name="save" class="au-btn au-btn--green">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>