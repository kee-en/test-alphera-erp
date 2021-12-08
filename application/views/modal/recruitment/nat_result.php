<!-- NAT RESULT MODAL -->
<div class="modal fade" id="nat_result_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-alphera font-20 m-0" id="nat_applicant_name"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="reload();">×</button>
            </div>
            <form action="javascript:void(0);" id="nat_result_form" name="nat_result_form" enctype="application/x-www-form-urlencoded">
                <div class="modal-body">
                    <h4 class="text-default font-18 mt-0 mb-1">Add NAT Exam Result</h4>
                    <p class="text-muted font-15" style="text-align: justify;">
                        Note: NAT result score that is lower than <span class="text-alphera text-underline">50</span> points will automatically mark as <span class="text-alphera text-underline">failed</span>.
                    </p>

                    <hr class="mt-0" style="border: 1px solid #f5f6f8;">

                    <div class="form-group">
                        <label>NAT Result <span class="asterisk">*</span></label>
                        <input type="hidden" id="n_app_code" name="n_app_code">
                        <input type="number" id="n_aptitude_test_score" name="n_aptitude_test_score" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= base_url('assets/javascript/nat_result.js') ?>"></script>