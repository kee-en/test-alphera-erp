<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"> <a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item"> <a href="#">Users</a></li>
                                <li class="breadcrumb-item"> User Responsibility</li>
                            </ol>
                        </div>
                        <h4 class="page-title">User Responsibility</li>
                        </h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-5">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">User Responsibility</p>
                            <span class="text-muted">Fill up the required fields below.</span>
                        </div>
                        <div class="card-body">
                            <form action="javascript:void(0)" id="user_responsibility_form">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <select class="custom-select" id="user_group" name="user_group">
                                            <option value="">Select User Group</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 mt-1">
                                        <div class="checkbox checkbox-alphera form-check-inline">
                                            <input type="checkbox" class="interview_id" id="int_1" name="interview_form[]" value="1">
                                            <label for="int_1"> Interview for General </label>
                                        </div>
                                        <div class="checkbox checkbox-alphera form-check-inline">
                                            <input type="checkbox" class="interview_id" id="int_2" name="interview_form[]" value="2">
                                            <label for="int_2"> Interview for Technical </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="text-lg-right mt-3 mt-lg-0">
                                            <button type="submit" class="btn btn-alphera">Save Changes</button>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="form-group">
                                    <div class="checkbox checkbox-alphera mb-1">
                                        <input type="checkbox" name="module[]" id="module_1">
                                        <label for="module_1" style="font-weight: 500;">Recruitment</label>
                                    </div>

                                    <div class="pt-1 pl-4">
                                        <div class="checkbox checkbox-alphera mb-1">
                                            <input type="checkbox" class="check_all" name="submodule_1[]" id="submodule_1">
                                            <label for="submodule_1">Create New Application</label>
                                        </div>
                                    </div>

                                    <div class="pt-1 pl-4">
                                        <div class="checkbox checkbox-alphera mb-1">
                                            <input type="checkbox" class="check_all" name="submodule_1[]" id="submodule_2">
                                            <label for="submodule_2">Registered Applicants</label>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <p class="text-alphera font-20 m-0">List of User Group</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100 table-bordered" id="user_group_table">
                                        <thead class="thead-alphera">
                                            <tr>
                                                <th>No.</th>
                                                <th>User Code</th>
                                                <th>User Type</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#user_group_table").DataTable({
                ajax: {
                    url: base_url + "get-user-group-table",
                    type: "POST"
                },
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    }
                },
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                }
            });
        });

        $(document).ready(function() {
            $('#module_1').click(function() {
                $('.check_all').prop('checked', this.checked);
            });

            $('.check_all').change(function() {
                var check = ($('.check_all').filter(":checked").length == $('.check_all').length);
                $('#module_1').prop("checked", check);
            });
        });
    </script>