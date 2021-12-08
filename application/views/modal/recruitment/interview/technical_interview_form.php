<style>
    .radio {
        text-align: center;
        margin-top: -5px;
    }
</style>

<!-- ADD TECHNICAL INTERVIEW FORM MODAL -->
<div class="modal fade" id="technical_interview_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 65%;">
        <form action="javascript:void(0)" id="technical_interview_form" name="technical_interview_form" enctype="application/x-www-form-urlencoded">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-alphera font-20 m-0"><span id="ti_applicant_name"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reload();">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="ti_applicant_code" name="ti_applicant_code">
                    <input type="hidden" id="ti_crew_code" name="ti_crew_code">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p class="text-alphera font-20 font-weight-medium mb-0">TECHNICAL INTERVIEW FORM</p>
                            <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span>
                        </div>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-sm table-bordered mb-0">
                            <thead>
                                <tr class="text-center">
                                    <th id="text-alignment">Point of Interview</th>
                                    <th id="text-alignment" style="width: 13%;">Score</th>
                                    <th id="text-alignment">
                                        <div class="row text-center">
                                            <div class="col-md-3">
                                                Very Good
                                            </div>
                                            <div class="col-md-3">
                                                Good
                                            </div>
                                            <div class="col-md-3">
                                                Normal
                                            </div>
                                            <div class="col-md-3">
                                                Poor
                                            </div>
                                        </div>
                                    </th>
                                    <th id="text-alignment">Remark</th>
                                </tr>
                            </thead>
                            <tbody id="list_of_technical_form">

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-center" id="text-alignment">Total Score</td>
                                    <td class="text-center"><input type="number" id="total_interview_technical" name="total_interview_technical" class="form-control text-center font-weight-medium" value="0" readonly></td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td class="text-center" id="text-alignment">Final Result</td>
                                    <td class="text-center"><input type="text" id="final_interview_technical" name="final_interview_technical" class="form-control text-center" value="-" readonly></td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="font-weight-medium"><span class="asterisk">*</span> Very Good 5, Good 4, Normal 3, Poor 2 </p>
                            <p class="font-weight-medium "><span class="asterisk">*</span> Newly employed officer or engineer should be obtained total score more than "75"</p>
                            <div class="form-group">
                                <label for="example-textarea">Remark (If necessary)
                                </label>
                                <textarea class="form-control" id="final_remark_technical" name="final_remark_technical" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group dropup mr-auto">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Export As <i class="mdi mdi-chevron-up"></i></button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" onclick="printTechnicalFormPdf()">PDF</a>
                            <a class="dropdown-item" onclick="printTechnicalFormXl()">EXCEL</a>
                        </div>
                    </div>
                    <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="<?= base_url('assets/javascript/technical_interview_form.js') ?>"></script>