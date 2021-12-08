<div class="modal fade" id="choosePrintModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Print Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                        <?php if (!empty($post)) : ?>
                            <?php foreach ($post as $key) : ?>
                            <button type="button" id="BtnEvaluation" onclick="printEvaluationFormPdf('<?= $key['applicant_code'] ?>')" class="btn btn-block btn--md btn-info waves-effect waves-light" style="display: none;">Print PDF</button>
                            <button type="button" id="BtnGeneral" onclick="printGeneralFormPdf('<?= $key['applicant_code'] ?>')" class="btn btn-block btn--md btn-info waves-effect waves-light" style="display: none;">Print PDF</button>
                            <button type="button" id="BtnTechnical" onclick="printTechnicalFormPdf('<?= $key['applicant_code'] ?>')" class="btn btn-block btn--md btn-info waves-effect waves-light" style="display: none;">Print PDF</button>
                            <button type="button" id="BtnEmployed" onclick="printEmployedFormPdf('<?= $key['applicant_code'] ?>')" class="btn btn-block btn--md btn-info waves-effect waves-light" style="display: none;">Print PDF</button>
                            <button type="button" id="BtnInterview" onclick="printInterviewFormPdf('<?= $key['applicant_code'] ?>')" class="btn btn-block btn--md btn-info waves-effect waves-light" style="display: none;">Print PDF</button>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                        <?php if (!empty($post)) : ?>
                            <?php foreach ($post as $key) : ?>
                            <button type="button" id="BtnEvaluationXl" onclick="printEvaluationFormXl('<?= $key['applicant_code'] ?>')" class="btn btn-block btn--md btn-info waves-effect waves-light" style="display: none;">Print Excel</button>
                            <button type="button" id="BtnGeneralXl" onclick="printGeneralFormXl('<?= $key['applicant_code'] ?>')" class="btn btn-block btn--md btn-info waves-effect waves-light" style="display: none;">Print Excel</button>
                            <button type="button" id="BtnTechnicalXl" onclick="printTechnicalFormXl('<?= $key['applicant_code'] ?>')" class="btn btn-block btn--md btn-info waves-effect waves-light" style="display: none;">Print Excel</button>
                            <button type="button" id="BtnEmployedXl" onclick="printEmployedFormXl('<?= $key['applicant_code'] ?>')" class="btn btn-block btn--md btn-info waves-effect waves-light" style="display: none;">Print Excel</button>
                            <button type="button" id="BtnInterviewXl" onclick="printInterviewFormXl('<?= $key['applicant_code'] ?>')" class="btn btn-block btn--md btn-info waves-effect waves-light" style="display: none;">Print Excel</button>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>