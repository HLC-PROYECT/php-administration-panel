<?php

use HLC\AP\Views\Helpers\ComponentsHelper;

?>
<div class="modal fade" id="addTask" tabindex="-1" role="dialog" aria-labelledby="addTaskLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form action="Subject/SubjectInsert" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubjectLabel">New subject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input required class="au-input au-input--full" type="text" name="name"
                               placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label>Number of hours</label>
                        <input required class="au-input au-input--full" type="text" name="nHours"
                               placeholder="Number of hours">
                    </div>
                    <div class="form-group">
                        <label>Ending year</label>
                        <input class="au-input au-input--full" id="finicio" type="date"
                               name="endingYear"
                               placeholder="yyyy">
                    </div>
                    <div class="form-group">
                        <div>
                            <label for="course" class="form-control-label">Course</label>
                        </div>
                        <div>
                            <?=
                                ComponentsHelper::selectorBuilder(
                                        "course",
                                    "course",
                                    $this->courses,
                                    ["getCourseId", "getDescription"]
                                )
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <label for="teacher" class="form-control-label">Teacher</label>
                        </div>
                        <div>
                            <?=
                            ComponentsHelper::selectorBuilder(
                                "teacher",
                                "teacher",
                                $this->teachers,
                                ["getEmail", "getName"]
                            )
                            ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" class="au-btn au-btn--green">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
