<!-- VIEW MEDICAL MODAL -->
<div class="modal fade" id="v_medical_modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 65%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-alphera font-20 m-0"><span id="m_crew_name"></span></h4>
                <input type="hidden" id="crew_code_hid" name="crew_code_hid">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reload();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <p class="text-alphera font-20 mb-0">List of Medical Records</p>
                        <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-hover m-0 table-centered dt-responsive w-100 table-bordered" id="medical_table">
                            <thead class="thead-alphera">
                                <tr>
                                    <th>No.</th>
                                    <th>Date of Med. Exam</th>
                                    <th>Date of Expiry</th>
                                    <th>Position</th>
                                    <th>BMI</th>
                                    <th>Remarks</th>
                                    <th>Date Created</th>
                                    <th>Medical Status</th>
                                    <th>Document Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-8" id="navigation-align">
                    </div>
                    <div class="col-md-4 text-right">
                        <div class="count-pagination" id="pagination_medical"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= base_url('assets/javascript/v_medical.js') ?>"></script>