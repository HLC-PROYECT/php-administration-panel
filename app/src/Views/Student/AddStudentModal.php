<div class="modal fade" id="addTask" tabindex="-1" role="dialog" aria-labelledby="addTaskLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form action="/student/save" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCourseLabel">New course</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Email</label>
                        <input required class="au-input au-input--full"
                               id="form_email"
                               type="email"
                               name="email"
                               placeholder="email">
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input required class="au-input au-input--full"
                               type="text"
                               id="form_name"
                               name="name"
                               placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label>Nick</label>
                        <input required class="au-input au-input--full"
                               id="form_nick"
                               type="text"
                               name="Nick"
                               placeholder="Nick">
                    </div>
                    <div class="form-group">
                        <label>Course Id</label>
                        <input required class="au-input au-input--full"
                               id="form_courseId"
                               type="number"
                               name="courseId"
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