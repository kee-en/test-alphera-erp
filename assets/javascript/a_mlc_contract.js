$(function () {
    formVessel("mlc_vessel_name");
    formTypeVessel("mlc_vessel_type");
    formNationality("mlc_farer_nationality");
    formAllPosition("mlc_farer_duty");
});

$("#c_mlc_contract").on("change", function () {
    if (this.value == "1") {
        $("#vc_form_number").html('SCRE-04B-02');
        $("#vc_revision_number").html('03');
        $("#vc_revision_date").html('2019-01-01');

        $("#mlc_form_number").val('SCRE-04B-02');
        $("#mlc_revision_number").val('03');
        $("#mlc_revision_date").val('2019-01-01');

        $("#col_form_details").show();
        $("#col_form_mlc").show();

        $("#six_k_header").show();
        $("#seven_k_header").show();
        $("#eight_k_header").show();
        $("#nine_k_header").show();

        $("#six_korean_flag").show();
        $("#seven_korean_flag").show();
        $("#eight_korean_flag").show();
        $("#nine_korean_flag").show();
        $("#etc_korean_flag").show();

        $("#six_mp_header").hide();
        $("#seven_mp_header").hide();
        $("#eight_mp_header").hide();
        $("#nine_mp_header").hide();

        $("#six_panama_flag").hide();
        $("#seven_panama_flag").hide();
        $("#eight_panama_flag").hide();
        $("#nine_panama_flag").hide();
        $("#etc_panama_flag").hide();

        $("#six_marshall_flag").hide();
        $("#seven_marshall_flag").hide();
        $("#eight_marshall_flag").hide();
        $("#nine_marshall_flag").hide();
        $("#etc_marshall_flag").hide();

    } else if (this.value == "2") {
        $("#vc_form_number").html('SCRE-04B-01-02');
        $("#vc_revision_number").html('04');
        $("#vc_revision_date").html('2019-07-19');

        $("#mlc_form_number").val('SCRE-04B-01-02');
        $("#mlc_revision_number").val('04');
        $("#mlc_revision_date").val('2019-07-19');

        $("#col_form_details").show();
        $("#col_form_mlc").show();

        $("#six_mp_header").show();
        $("#seven_mp_header").show();
        $("#eight_mp_header").show();
        $("#nine_mp_header").show();

        $("#six_k_header").hide();
        $("#seven_k_header").hide();
        $("#eight_k_header").hide();
        $("#nine_k_header").hide();

        $("#six_panama_flag").show();
        $("#seven_panama_flag").show();
        $("#eight_panama_flag").show();
        $("#nine_panama_flag").show();
        $("#etc_panama_flag").show();

        $("#six_marshall_flag").hide();
        $("#seven_marshall_flag").hide();
        $("#eight_marshall_flag").hide();
        $("#nine_marshall_flag").hide();
        $("#etc_marshall_flag").hide();

        $("#six_korean_flag").hide();
        $("#seven_korean_flag").hide();
        $("#eight_korean_flag").hide();
        $("#nine_korean_flag").hide();
        $("#etc_korean_flag").hide();
    } else if (this.value == "3") {
        $("#vc_form_number").html('SCRE-04B-01-01');
        $("#vc_revision_number").html('04');
        $("#vc_revision_date").html('2019-07-19');

        $("#mlc_form_number").val('SCRE-04B-01-01');
        $("#mlc_revision_number").val('04');
        $("#mlc_revision_date").val('2019-07-19');

        $("#col_form_details").show();
        $("#col_form_mlc").show();

        $("#six_mp_header").show();
        $("#seven_mp_header").show();
        $("#eight_mp_header").show();
        $("#nine_mp_header").show();

        $("#six_k_header").hide();
        $("#seven_k_header").hide();
        $("#eight_k_header").hide();
        $("#nine_k_header").hide();

        $("#six_marshall_flag").show();
        $("#seven_marshall_flag").show();
        $("#eight_marshall_flag").show();
        $("#nine_marshall_flag").show();
        $("#etc_marshall_flag").show();

        $("#six_korean_flag").hide();
        $("#seven_korean_flag").hide();
        $("#eight_korean_flag").hide();
        $("#nine_korean_flag").hide();
        $("#etc_korean_flag").hide();

        $("#six_panama_flag").hide();
        $("#seven_panama_flag").hide();
        $("#eight_panama_flag").hide();
        $("#nine_panama_flag").hide();
        $("#etc_panama_flag").hide();
    } else {
        $("#vc_form_number").html('-');
        $("#vc_revision_number").html('-');
        $("#vc_revision_date").html('-');
        $("#col_form_details").show();
        $("#col_form_mlc").show();
    }
});

function addCrewMLCContract(crew_code) {
    $.ajax({
        url: base_url + "get-crew-information",
        type: "POST",
        data: {
            code: crew_code,
        },
        dataType: "JSON",
        success: function (data) {
            $("#mlc_crew_code").val(data.crew_code);
            $("#mlc_monitor_code").val(data.monitor_code);
            $('#mlc_vessel_name').val(data.vessel_assign);
            $('#mlc_vessel_type').val(formatVesselTypeIdByVessel(data.vessel_assign));
            $('#mlc_farer_duty').val(data.position);
            getApplicantInformation(data.crew_code);
			getLicensesPassport(data.crew_code)
            $("#add_mlc_contract_modal").modal("show");
        },
    });
}

function getApplicantInformation(crew_code) {
	$.ajax({
		url: base_url + "get-applicant-information",
		type: "POST",
		data: {
			code: crew_code,
		},
		dataType: "JSON",
		success: function (data) {
			var full_name =
				data.first_name + " " + data.middle_name + " " + data.last_name;

			$("#a_mlc_crew_name").html(full_name);

			$("#mlc_farer_name").val(full_name);
			$("#mlc_name_of_seafared").val(full_name);
			$("#mlc_farer_birthdate").val(data.birth_date);
			$("#mlc_farer_nationality").val(data.nationality);
		},
	});
}

function getLicensesPassport(crew_code){
    $.ajax({
		url: base_url + "get-numbers",
		type: "POST",
		data: {
			crew_code: crew_code,
		},
		dataType: "JSON",
		success: function (data) {
			var number = JSON.parse(data.number);
            $("#mlc_farer_passport").val(number[5]);
            $("#mlc_farer_book").val(number[6]);
            $("#mlc_farer_license").val(number[0]);
		},
	});
}

$("#mlc_contract_form").submit(function () {
    $.ajax({
        url: base_url + "create-mlc-contract",
        type: "POST",
		data: $("#mlc_contract_form").serialize(),
		beforeSend: function () {
			$("#BtnAddContractMLC").html(
				'<span class="spinner-border spinner-border-sm" mr-1" role="status" aria-hidden="true"></span> Please wait...'
			);
			$("#BtnAddContractMLC").prop("disabled", true);
		},
        success: function (data) {
            validationInput(data.c_mlc_contract, "c_mlc_contract");
            validationInput(data.mlc_vessel_name, "mlc_vessel_name");
            validationInput(data.mlc_vessel_type, "mlc_vessel_type");
            validationInput(data.mlc_farer_duty, "mlc_farer_duty");
            validationInput(data.mlc_farer_passport, "mlc_farer_passport");
            validationInput(data.mlc_farer_book, "mlc_farer_book");
            validationInput(data.mlc_farer_license, "mlc_farer_license");
            validationInput(data.mlc_farer_sex, "mlc_farer_sex");
            validationInput(data.mlc_sign_place, "mlc_sign_place");
            validationInput(data.mlc_sign_date, "mlc_sign_date");
            validationInput(data.mlc_bw, "mlc_bw");
            validationInput(data.mlc_ot, "mlc_ot");
            validationInput(data.mlc_pl, "mlc_pl");
            validationInput(data.mlc_sa, "mlc_sa");
            validationInput(data.mlc_rb, "mlc_rb");
            validationInput(data.mlc_mts, "mlc_mts");
            validationInput(data.mlc_fksu, "mlc_fksu");
            validationInput(data.mlc_mt, "mlc_mt");
            validationInput(data.mlc_employment_period_from, "mlc_employment_period_from");
            validationInput(data.mlc_employment_period_to, "mlc_employment_period_to");
            validationInput(data.mlc_shipowner_vessel, "mlc_shipowner_vessel");
            validationInput(data.mlc_vp_alphera, "mlc_vp_alphera");

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
                        location.reload(true);
                    }
                });
			}
			$("#BtnAddContractMLC").html(
				'Add'
			);
			$("#BtnAddContractMLC").prop("disabled", false);
        },
    });
});

$("#c_mlc_contract").change(function (){
	$.ajax({
		url: base_url + "add-mlc-contract-validation",
		type: "POST",
		data: $("#mlc_contract_form").serialize(),
		success: function (data) {
			validationInput(data.c_mlc_contract, "c_mlc_contract");
		},
	});
});

$("#mlc_farer_passport").keyup(function (){
	$.ajax({
		url: base_url + "add-mlc-contract-validation",
		type: "POST",
		data: $("#mlc_contract_form").serialize(),
		success: function (data) {
			validationInput(data.mlc_farer_passport, "mlc_farer_passport");
		},
	});
});

$("#mlc_farer_book").keyup(function (){
	$.ajax({
		url: base_url + "add-mlc-contract-validation",
		type: "POST",
		data: $("#mlc_contract_form").serialize(),
		success: function (data) {
			validationInput(data.mlc_farer_book, "mlc_farer_book");
		},
	});
});

$("#mlc_farer_license").keyup(function (){
	$.ajax({
		url: base_url + "add-mlc-contract-validation",
		type: "POST",
		data: $("#mlc_contract_form").serialize(),
		success: function (data) {
			validationInput(data.mlc_farer_license, "mlc_farer_license");
		},
	});
});

$("#mlc_farer_sex").keyup(function (){
	$.ajax({
		url: base_url + "add-mlc-contract-validation",
		type: "POST",
		data: $("#mlc_contract_form").serialize(),
		success: function (data) {
			validationInput(data.mlc_farer_sex, "mlc_farer_sex");
		},
	});
});

$("#mlc_sign_place").keyup(function (){
	$.ajax({
		url: base_url + "add-mlc-contract-validation",
		type: "POST",
		data: $("#mlc_contract_form").serialize(),
		success: function (data) {
			validationInput(data.mlc_sign_place, "mlc_sign_place");
		},
	});
});

$("#mlc_sign_date").change(function (){
	$.ajax({
		url: base_url + "add-mlc-contract-validation",
		type: "POST",
		data: $("#mlc_contract_form").serialize(),
		success: function (data) {
			validationInput(data.mlc_sign_date, "mlc_sign_date");
		},
	});
});

$("#mlc_bw").keyup(function (){
	$.ajax({
		url: base_url + "add-mlc-contract-validation",
		type: "POST",
		data: $("#mlc_contract_form").serialize(),
		success: function (data) {
			validationInput(data.mlc_bw, "mlc_bw");
		},
	});
});

$("#mlc_ot").keyup(function (){
	$.ajax({
		url: base_url + "add-mlc-contract-validation",
		type: "POST",
		data: $("#mlc_contract_form").serialize(),
		success: function (data) {
			validationInput(data.mlc_ot, "mlc_ot");
		},
	});
});

$("#mlc_pl").keyup(function (){
	$.ajax({
		url: base_url + "add-mlc-contract-validation",
		type: "POST",
		data: $("#mlc_contract_form").serialize(),
		success: function (data) {
			validationInput(data.mlc_pl, "mlc_pl");
		},
	});
});

$("#mlc_sa").keyup(function (){
	$.ajax({
		url: base_url + "add-mlc-contract-validation",
		type: "POST",
		data: $("#mlc_contract_form").serialize(),
		success: function (data) {
			validationInput(data.mlc_sa, "mlc_sa");
		},
	});
});

$("#mlc_rb").keyup(function (){
	$.ajax({
		url: base_url + "add-mlc-contract-validation",
		type: "POST",
		data: $("#mlc_contract_form").serialize(),
		success: function (data) {
			validationInput(data.mlc_rb, "mlc_rb");
		},
	});
});

$("#mlc_mts").keyup(function (){
	$.ajax({
		url: base_url + "add-mlc-contract-validation",
		type: "POST",
		data: $("#mlc_contract_form").serialize(),
		success: function (data) {
			validationInput(data.mlc_mts, "mlc_mts");
		},
	});
});

$("#mlc_fksu").keyup(function (){
	$.ajax({
		url: base_url + "add-mlc-contract-validation",
		type: "POST",
		data: $("#mlc_contract_form").serialize(),
		success: function (data) {
			validationInput(data.mlc_fksu, "mlc_fksu");
		},
	});
});

$("#mlc_mt").keyup(function (){
	$.ajax({
		url: base_url + "add-mlc-contract-validation",
		type: "POST",
		data: $("#mlc_contract_form").serialize(),
		success: function (data) {
			validationInput(data.mlc_mt, "mlc_mt");
		},
	});
});

$("#mlc_employment_period_from").change(function (){
	$.ajax({
		url: base_url + "add-mlc-contract-validation",
		type: "POST",
		data: $("#mlc_contract_form").serialize(),
		success: function (data) {
			validationInput(data.mlc_employment_period_from, "mlc_employment_period_from");
		},
	});
});
$("#mlc_employment_period_to").change(function (){
	$.ajax({
		url: base_url + "add-mlc-contract-validation",
		type: "POST",
		data: $("#mlc_contract_form").serialize(),
		success: function (data) {
			validationInput(data.mlc_employment_period_to, "mlc_employment_period_to");
		},
	});
});

$("#mlc_shipowner_vessel").keyup(function (){
	$.ajax({
		url: base_url + "add-mlc-contract-validation",
		type: "POST",
		data: $("#mlc_contract_form").serialize(),
		success: function (data) {
			validationInput(data.mlc_shipowner_vessel, "mlc_shipowner_vessel");
		},
	});
});

$("#mlc_vp_alphera").keyup(function (){
	$.ajax({
		url: base_url + "add-mlc-contract-validation",
		type: "POST",
		data: $("#mlc_contract_form").serialize(),
		success: function (data) {
			validationInput(data.mlc_vp_alphera, "mlc_vp_alphera");
		},
	});
});