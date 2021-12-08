<!-- VIEW / EDIT PRE JOINING AND VISA MODAL -->
<div class="modal fade" id="disembarked_routing_slip_modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <form action="javascript:void(0);" id="drsm_routing_slip_form">
        <div class="modal-dialog modal-dialog-scrollable" style="max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-alphera font-20 m-0" id="drsm_crew_name"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="reload();">×</button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12 text-center">
                            <p class="text-alphera font-20 font-weight-medium mb-0">ROUTING SLIP FOR DISEMBARKED CREW</p>
                            <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span>
                        </div>
                    </div>

                    <input type="hidden" id="mntr_code" name="mntr_code">
                    <input type="hidden" id="crw_code" name="crw_code">
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0">
                                    <!-- [START] -->
                                    <thead>
                                        <tr>
                                            <td id="text-alignment">Name:</td>
                                            <td id="text-alignment" class=crew_name>Christine Silva</td>
                                            <td id="text-alignment">Rank:</td>
                                            <td id="text-alignment" class="crew_pos">Master (MSTR)</td>
                                            <td id="text-alignment">Vessel:</td>
                                            <td id="text-alignment" class="crew_vsl">ARBORELLA (A/B)</td>
                                            <td id="text-alignment">Date of Disembarkation:</td>
                                            <td id="text-alignment" class="crew_disembark">June 30, 2021</td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="text-center thead-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>Subject Routine</th>
                                            <th>In Charge</th>
                                            <th>Remarks</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td rowspan="5">1</td>
                                            <td>a. Debriefing / Onboarding Feedback</td>
                                            <td rowspan="5" class="text-center" id="text-alignment">Crewing</td>
                                            <td>
                                                <textarea class="form-control" id="drsm_remarks_1" name="drsm_remarks_1" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="drsm_cs_1" value="0" name="drsm_cs_status_1">
                                                    <label for="drsm_cs_status_1"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="drsmd_cs_1" value="1" name="drsm_cs_status_1">
                                                    <label for="drsm_cs_status_1"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>b. Situation On Board</td>
                                            <td>
                                                <textarea class="form-control" id="drsm_remarks_2" name="drsm_remarks_2" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="drsm_cs_2" value="0" name="drsm_cs_status_2">
                                                    <label for="drsm_cs_status_2"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="drsmd_cs_2" value="1" name="drsm_cs_status_2">
                                                    <label for="drsm_cs_status_2"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>c. Next Vessel Assignment</td>
                                            <td>
                                                <textarea class="form-control" id="drsm_remarks_3" name="drsm_remarks_3" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="drsm_cs_3" value="0" name="drsm_cs_status_3">
                                                    <label for="drsm_cs_status_3"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="drsmd_cs_3" value="1" name="drsm_cs_status_3">
                                                    <label for="drsm_cs_status_3"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>c. Next Reporting Schedule</td>
                                            <td>
                                                <textarea class="form-control" id="drsm_remarks_4" name="drsm_remarks_4" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="drsm_cs_4" value="0" name="drsm_cs_status_4">
                                                    <label for="drsm_cs_status_4"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="drsmd_cs_4" value="1" name="drsm_cs_status_4">
                                                    <label for="drsm_cs_status_4"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>d. Training and documents to be completed before reporting</td>
                                            <td>
                                                <textarea class="form-control" id="drsm_remarks_5" name="drsm_remarks_5" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="drsm_cs_5" value="0" name="drsm_cs_status_5">
                                                    <label for="drsm_cs_status_5"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="drsmd_cs_5" value="1" name="drsm_cs_status_5">
                                                    <label for="drsm_cs_status_5"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>General Debriefing</td>
                                            <td class="text-center" id="text-alignment">Management</td>
                                            <td>
                                                <textarea class="form-control" id="drsm_remarks_6" name="drsm_remarks_6" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="drsm_cs_6" value="0" name="drsm_cs_status_6">
                                                    <label for="drsm_cs_status_6"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="drsmd_cs_6" value="1" name="drsm_cs_status_6">
                                                    <label for="drsm_cs_status_6"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Checking of Documents for Renewal</td>
                                            <td class="text-center" id="text-alignment">DOCS & PROCESSINGS</td>
                                            <td>
                                                <textarea class="form-control" id="drsm_remarks_7" name="drsm_remarks_7" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="drsm_cs_7" value="0" name="drsm_cs_status_7">
                                                    <label for="drsm_cs_status_7"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="drsmd_cs_7" value="1" name="drsm_cs_status_7">
                                                    <label for="drsm_cs_status_7"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Seafare's Feedback (SSQ)</td>
                                            <td class="text-center" id="text-alignment">HR / ADMIN</td>
                                            <td>
                                                <textarea class="form-control" id="drsm_remarks_8" name="drsm_remarks_8" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="drsm_cs_8" value="0" name="drsm_cs_status_8">
                                                    <label for="drsm_cs_status_8"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="drsmd_cs_8" value="1" name="drsm_cs_status_8">
                                                    <label for="drsm_cs_status_8"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>Individualized training / briefing based on Crew Manager's assessment</td>
                                            <td class="text-center" id="text-alignment">TRAINING</td>
                                            <td>
                                                <textarea class="form-control" id="drsm_remarks_9" name="drsm_remarks_9" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="drsm_cs_9" value="0" name="drsm_cs_status_9">
                                                    <label for="drsm_cs_status_9"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="drsmd_cs_9" value="1" name="drsm_cs_status_9">
                                                    <label for="drsm_cs_status_9"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>Medical Repatriation Briefing <i>(For medically repatriated only)</i></td>
                                            <td class="text-center" id="text-alignment">HR / ADMIN</td>
                                            <td>
                                                <textarea class="form-control" id="drsm_remarks_10" name="drsm_remarks_10" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="drsm_cs_10" value="0" name="drsm_cs_status_10">
                                                    <label for="drsm_cs_status_10"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="drsmd_cs_10" value="1" name="drsm_cs_status_10">
                                                    <label for="drsm_cs_status_10"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>Leave Pay</td>
                                            <td class="text-center" id="text-alignment">Accounting</td>
                                            <td>
                                                <textarea class="form-control" id="drsm_remarks_11" name="drsm_remarks_11" rows="2"></textarea>
                                            </td>
                                            <td class="text-center" id="text-alignment">
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="drsm_cs_11" value="0" name="drsm_cs_status_11">
                                                    <label for="drsm_cs_status_11"> Pending </label>
                                                </div>
                                                <div class="radio radio-alphera form-check-inline">
                                                    <input type="radio" id="drsmd_cs_11" value="1" name="drsm_cs_status_11">
                                                    <label for="drsm_cs_status_11"> Done </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alphera" data-dismiss="modal" onclick="reload();">Close</button>
                    <button type="submit" class="btn btn-primary" id="BtnDisSubmitRoutingSlip">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>

$("#drsm_routing_slip_form").submit(function () {
	$.ajax({
		url: base_url + "save-disembark-routing-slip",
		type: "POST",
		data: $("#drsm_routing_slip_form").serialize(),
		beforeSend: function () {
			$("#BtnDisSubmitRoutingSlip").html(
				'<span class="spinner-border spinner-border-sm" mr-1" role="status" aria-hidden="true"></span> Please wait...'
			);
			$("#BtnDisSubmitRoutingSlip").prop("disabled", true);
		},
		success: function (data) {

			if (data.type) {
				Swal.fire({
					icon: data.type,
					title: data.title,
					text: data.text,
					confirmButtonText: "Close",
					allowOutsideClick: false,
					allowEscapeKey: false,
				}).then(function () {
					if (data.type === 'success') {
                        location.reload();
					}
				});
			}
			$("#BtnDisSubmitRoutingSlip").html(
				'Submit'
			);
			$("#BtnDisSubmitRoutingSlip").prop("disabled", false);
		}
	});
});
</script>