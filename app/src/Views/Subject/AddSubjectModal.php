<?php

use HLC\AP\Views\Helpers\componentsHelper;

?>
<div class="modal fade" id="addSubject" tabindex="-1" role="dialog" aria-labelledby="addSubjectLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form action="subject/save" method="post">
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
                        <input class="au-input au-input--full" id="finicio" type="number"
                               min="2000"
                               max="3000"
                               name="endingYear"
                               placeholder="yyyy">
                    </div>
                    <div class="form-group">
                        <div>
                            <label for="course" class="form-control-label">Course</label>
                        </div>
                        <div>
                            <?=
                                componentsHelper::selectorBuilder(
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
                            componentsHelper::selectorBuilder(
                                "teacher",
                                "teacher",
                                $this->teachers,
                                ["getIdentificationDocument", "getName"]
                            )
                            ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input hidden type="text" name="id">
                    <button type="submit" name="submit" class="au-btn au-btn--green">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
