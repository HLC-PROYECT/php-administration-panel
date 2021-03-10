<div class="modal fade" id="addTask" tabindex="-1" role="dialog" aria-labelledby="addTaskLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form action="/course/save" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCourseLabel">New course</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Education center</label>
                        <input required class="au-input au-input--full"
                               id="form_educationCenter"
                               type="text"
                               name="educationCenter"

                               placeholder="Education Center">
                    </div>
                    <div class="form-group">
                        <label>Start year</label>
                        <input class="au-input au-input--full"
                               type="number"
                               id="form_startYear"
                               name="startYear"
                               min="2000"
                               placeholder="Start Year">
                    </div>
                    <div class="form-group">
                        <label>End year</label>
                        <input class="au-input au-input--full"
                               id="form_endYear"
                               type="number"
                               name="endYear"
                               min="2000"
                               max="2050"
                               placeholder="End Year">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input class="au-input au-input--full"
                               id="form_description"
                               type="text"
                               name="description"
                               minlength="3"
                               placeholder="Description">
                    </div>

                    <input class="au-input au-input--full"
                           id="form_courseId"
                           type="hidden"
                           value="0"
                           name="courseId"
                           placeholder="Description">

                    <div class="modal-footer">
                        <button type="submit" name="saveCourse" class="au-btn au-btn--green">Save
                        </button>
                    </div>
            </form>
        </div>
    </div>
</div>