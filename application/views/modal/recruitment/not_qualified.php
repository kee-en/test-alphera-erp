<!-- NOT QUALIFIED MODAL -->
<div class="modal fade" id="not_qualified_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-alphera font-20 m-0">Confirmation Required</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="reload();">×</button>
            </div>
            <form action="javascript:void(0);" id="not_qualified_form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="example-textarea">Reasons why their employment application was rejected? <span class="text-alphera">*</span></label>
                        <input type="hidden" id="r_app_code" name="r_app_code">
                        <textarea class="form-control" id="r_add_remark" name="r_add_remark" rows="8" maxlength="280" placeholder="Provide any detail about your reasons for rejecting their employment application." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
                    <button type="submit" id="BtnSubmitNotQual" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>