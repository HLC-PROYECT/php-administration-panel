<div class="modal fade" id="addTask" tabindex="-1" role="dialog" aria-labelledby="addTaskLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form action="Course/CourseInsert" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskLabel">New course/h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Education center</label>
                        <input required class="au-input au-input--full" type="text" name="educationCenter"
                            placeholder="Education Center">
                    </div>
                    <div class="form-group">
                        <label>Start year</label>
                        <input class="au-input au-input--full" type="number" name="startYear" placeholder="Start Year">
                    </div>
                    <div class="form-group">
                        <label>End year</label>
                        <input class="au-input au-input--full" id="finicio" type="number" name="endYear"
                            placeholder="End Year">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input class="au-input au-input--full" id="description" type="text" name="description"
                            placeholder="Description">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submit" class="au-btn au-btn--green">Save</button>
                    </div>
            </form>
        </div>
    </div>
</div>