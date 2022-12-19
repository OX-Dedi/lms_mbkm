<script>
    
    function initDTEvents(){
    }

    var reportSubject = function () {
        // Private functions
        var reportDt = false;
        var currentFilter = false;
        var statisticChart = false;
        var barChart = false
        var columnDefs = [ {
                field: 'employeeid',
                title: 'NIP',
            },{
                field: 'fullname',
                title: 'Nama',
                autoHide: false
            },{
                field: 'lecturercode',
                title: 'Kode Dosen',
            },{
                field: 'course_view',
                title: 'Course View',
                autoHide: false,
            },{
                field: 'resource',
                title: 'Resource',
                width: 100,
                template: function(row){
                    var label = parseInt(row.label);
                    var page = parseInt(row.page);
                    var file = parseInt(row.resource);
                    var url = parseInt(row.url);
                    var rowData = "Label ("+label+")<br>";
                    rowData += "Page ("+page+")<br>";
                    rowData += "File ("+file+")<br>";
                    rowData += "URL ("+url+")<br>";
                    return rowData;
                },
                autoHide: false,
                sortable: false,
            },{
                field: 'activity',
                title: 'Activity',
                width: 100,
                template: function(row){
                    var assignment = parseInt(row.assignment);
                    var quiz = parseInt(row.quiz);
                    var forum = parseInt(row.forum);
                    var h5p = parseInt(row.hvp);
                    var active_quiz = parseInt(row.active_quiz);
                    var wiki = parseInt(row.wiki);
                    var chat = parseInt(row.chat);
                    var feedback = parseInt(row.feedback);
                    var vpl = parseInt(row.vpl);

                    var rowData = "Assignment ("+assignment+")<br>";
                    rowData += "Quiz ("+quiz+")<br>";
                    rowData += "Forum ("+forum+")<br>";
                    rowData += "H5P ("+h5p+")<br>";
                    rowData += "Active Quiz ("+active_quiz+")<br>";
                    rowData += "Wiki ("+wiki+")<br>";
                    rowData += "Chat ("+chat+")<br>";
                    rowData += "Feedback ("+feedback+")<br>";
                    rowData += "VPL ("+vpl+")<br>";
                    return rowData;
                },
                autoHide: false,
                sortable: false,
            },{
                field: 'sum',
                title: 'Sum Resource & Activity',
                autoHide: false
            }
        ]
        var options = {
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: "<?php echo base_url($controller_full_path."/datatable_subject"); ?>",
                        params:{
                            semester : () => {
                                return $("#mk_semester_filter").val()
                            },
                            study_program_id : () => {
                                return $("#mk_study_program_filter").val()
                            },
                            subject_code : () => {
                                return $("#mk_subject_filter").val()
                            },
                            teacher : () => {
                                return $('#mk_teacher_filter').val()
                            }
                        }
                    }
                },
                pageSize: 10,
                serverSide: true,
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true,
                timeout: 30000,
                saveState:
                    {
                        cookie: false,
                        webstorage: false
                    }
            },

            layout: {
                scroll: true, 
                height: 750, 
                footer: false 
            },
            // column sorting
            sortable: true,
            pagination: true,
            // columns definition
            columns: columnDefs,
        };
        var refreshParamInput = function(){
            currentFilter = {
                                semester : $("#mk_semester_filter").val(),
                                study_program_id : $("#mk_study_program_filter").val(),
                                subject_code : $("#mk_subject_filter").val(),
                                teacher : $("#mk_teacher_filter").val(),
                            }
            if(reportDt){
                var currentData = reportDt.getOption("data");
                currentData.source.read.params = currentFilter;
            }
        }
        var initDt = function () {
            options.search = {
                input: $('#generalSearch'),
                delay: 100
            };


            $("#mk_apply_filter").on("click", function () {
                if(!reportDt)
                    reportDt = $('#datatable-subject').KTDatatable(options);
                else
                    reportDt.reload();

                fetchStatistics();
            });
        };

        var initChart = function() {
            $("#nav-item-mk").click(function(){
                // fetchStatistics();
            })

            if ($('#kt_chart_subject_statistics').length == 0 || $('#kt_chart_subject_bar').length == 0) {
                return;
            }

            barChart = Morris.Bar({
                element: 'kt_chart_subject_bar',
                data: [{}],
                xkey: 'range',
                ykeys: ['dosen'],
                labels: ['Jumlah Dosen'],
                barColors: [
                    KTApp.getStateColor('danger'),
                    KTApp.getStateColor('warning'),
                    KTApp.getStateColor('success'),
                    KTApp.getStateColor('primary'),
                ],
                resize: true,
                xLabelAngle: 45
            })

            statisticChart = Morris.Donut({
                element: 'kt_chart_subject_statistics',
                data: [{}],
                colors: [
                    '#f44336',
                    '#E91E63',
                    '#9c27b0',
                    '#673ab7',
                    '#3f51b5',
                    '#2196F3',
                    '#03a9f4',
                    '#00bcd4',
                    '#009688',
                    '#4caf50',
                    '#8bc34a',
                    '#cddc39',
                    '#ffeb3b',
                    '#ffc107'
                ],
            });
        }

        var initFilter = function(){
            $("#mk_semester_filter,#mk_study_program_filter,#mk_subject_filter,#mk_teacher_filter").on("change",function(){
                refreshParamInput();
            });

            $("#mk_study_program_filter").change(function(){
                var studyProgramId = $(this).val();
                var semester = $("#mk_semester_filter").val();
                getSubjectFilter(studyProgramId,semester).then(function(){
                    refreshSubjectFilter("#mk_subject_filter");
                })
            });
            $("#mk_semester_filter").change(function(){
                var semester = $(this).val();
                var studyProgramId = $("#mk_study_program_filter").val();
                getSubjectFilter(studyProgramId,semester).then(function(){
                    refreshSubjectFilter("#mk_subject_filter");
                })
            });
        }

        var renderStatistics = function(data){
            // table = $('#mk_range_table')
            // table.empty()

            if(data != false){
                cluster = []
                totalDosen = 0;
                totalChanges = 0;
                for(const [range, dosen] of Object.entries(data.cluster)){
                    // table.append(`<tr><td>${range}</td><td>${dosen}</td></tr>`)
                    totalDosen += dosen
                    cluster.push({range: range, dosen: dosen})
                }
                barChart.setData(cluster)
                statistic = data.pie
                totalChanges = statistic.sum
                average = totalChanges / totalDosen
                $('#kt_chart_subject_bar').next().remove()
                $('#kt_chart_subject_bar').after('<p>Average Changes: ${average.toFixed(1)} changes per lecturer</p>')


                if(statistic.sum == 0){
                    labelPercent = '0%'
                    pagePercent = '0%'
                    filePercent = '0%'
                    urlPercent = '0%'
                    assignmentPercent = '0%'
                    quizPercent = '0%'
                    forumPercent = '0%'
                    h5pPercent = '0%'
                    activeQuizPercent = '0%'
                    wikiPercent = '0%'
                    chatPercent = '0%'
                    feedbackPercent = '0%'
                    vplPercent = '0%'
                    viewPercent = '0%'
                }else{
                    labelPercent = ((statistic.label / statistic.sum) * 100).toFixed(2) + '%'
                    pagePercent = ((statistic.page / statistic.sum) * 100).toFixed(2) + '%'
                    filePercent = ((statistic.resource / statistic.sum) * 100).toFixed(2) + '%'
                    urlPercent = ((statistic.url / statistic.sum) * 100).toFixed(2) + '%'
                    assignmentPercent = ((statistic.assignment / statistic.sum) * 100).toFixed(2) + '%'
                    quizPercent = ((statistic.quiz / statistic.sum) * 100).toFixed(2) + '%'
                    forumPercent = ((statistic.forum / statistic.sum) * 100).toFixed(2) + '%'
                    h5pPercent = ((statistic.hvp / statistic.sum) * 100).toFixed(2) + '%'
                    activeQuizPercent = ((statistic.active_quiz / statistic.sum) * 100).toFixed(2) + '%'
                    wikiPercent = ((statistic.wiki / statistic.sum) * 100).toFixed(2) + '%'
                    chatPercent = ((statistic.chat / statistic.sum) * 100).toFixed(2) + '%'
                    feedbackPercent = ((statistic.feedback / statistic.sum) * 100).toFixed(2) + '%'
                    vplPercent = ((statistic.vpl / statistic.sum) * 100).toFixed(2) + '%'
                    viewPercent = ((statistic.course_view / statistic.sum) * 100).toFixed(2) + '%'
                }

                statisticChart.setData([
                    {label: activeQuizPercent, value: statistic.active_quiz},
                    {label: assignmentPercent, value: statistic.assignment},
                    {label: chatPercent, value: statistic.chat},
                    {label: feedbackPercent, value: statistic.feedback},
                    {label: filePercent, value: statistic.resource},
                    {label: forumPercent, value: statistic.forum},
                    {label: h5pPercent, value: statistic.hvp},
                    {label: labelPercent, value: statistic.label},
                    {label: pagePercent, value: statistic.page},
                    {label: quizPercent, value: statistic.quiz},
                    {label: urlPercent, value: statistic.url},
                    {label: vplPercent, value: statistic.vpl},
                    {label: wikiPercent, value: statistic.wiki},
                    {label: viewPercent, value: statistic.course_view},
                ])

                setTimeout(function(){
                    statisticChart.redraw()
                    barChart.redraw()
                },10)

                $("#mk_percent1").html(statistic.active_quiz.toLocaleString('id-Id')+" active quiz changes");
                $("#mk_percent2").html(statistic.assignment.toLocaleString('id-Id')+" assignment changes");
                $("#mk_percent3").html(statistic.chat.toLocaleString('id-Id')+" chat changes");
                $("#mk_percent4").html(statistic.feedback.toLocaleString('id-Id')+" feedback changes");
                $("#mk_percent5").html(statistic.resource.toLocaleString('id-Id')+" file changes");
                $("#mk_percent6").html(statistic.forum.toLocaleString('id-Id')+" forum changes");
                $("#mk_percent7").html(statistic.hvp.toLocaleString('id-Id')+" h5p changes");
                $("#mk_percent8").html(statistic.label.toLocaleString('id-Id')+" label changes");
                $("#mk_percent9").html(statistic.page.toLocaleString('id-Id')+" page changes");
                $("#mk_percent10").html(statistic.quiz.toLocaleString('id-Id')+" quiz changes");
                $("#mk_percent11").html(statistic.url.toLocaleString('id-Id')+" url changes");
                $("#mk_percent12").html(statistic.vpl.toLocaleString('id-Id')+" vpl changes");
                $("#mk_percent13").html(statistic.wiki.toLocaleString('id-Id')+" wiki changes");
                $("#mk_percent14").html(statistic.course_view.toLocaleString('id-Id')+" course view");
                $("#mk_percent15").html(statistic.sum.toLocaleString('id-Id')+" total changes");
            }else{
                barChart.setData([{range: 'range', dosen: 0}])
                statisticChart.setData([{label: 'change', value: 0}])
            }

        }

        var fetchStatistics = function(){
            KTApp.blockPage();
            $.ajax({
                type : 'GET',
                url : "<?php echo base_url($controller_full_path."/statistic_subject"); ?>",
                dataType : "json",
                data : currentFilter,
                success : function(response,status){
                    KTApp.unblockPage();
                    if(response.status == true){
                        renderStatistics(response.data);
                    }else{
                        renderStatistics(false);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown){
                    KTApp.unblockPage();
                    renderStatistics(false);
                }
            });  
        }


        return {
            init: function () {
                initDt();
                initChart();
                initFilter();
                refreshParamInput();
                renderStatistics(false);
            },

        };
    }();

    var reportStudyProg = function () {
        // Private functions
        var reportDt = false;
        var currentFilter = false;
        var statisticChart = false;
        var barChart = false;
        var options = {
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: "<?php echo base_url($controller_full_path."/datatable_study_program"); ?>",
                        params:{
                            semester : () => {
                                return $("#prodi_semester_filter").val()
                            } ,
                            faculty_id : () => {
                                return $("#prodi_faculty_filter").val()
                            },
                            study_program_id : () => {
                                return $("#prodi_study_program_filter").val()
                            },
                        }
                    }
                },
                pageSize: 10,
                serverSide: true,
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true,
                timeout: 30000,
                saveState:
                    {
                        cookie: false,
                        webstorage: false
                    }
            },

            layout: {
                scroll: true, 
                height: 750, 
                footer: false 
            },
            // column sorting
            sortable: true,
            pagination: true,
            // columns definition
            columns: [ {
                field: 'category_name',
                title: 'Study Program',
            },{
                field: 'course_view',
                title: 'Course View',
                autoHide: false,
            },{
                field: 'resource',
                title: 'Resource',
                width: 100,
                template: function(row){
                    var label = parseInt(row.label);
                    var page = parseInt(row.page);
                    var file = parseInt(row.resource);
                    var url = parseInt(row.url);
                    var rowData = "Label ("+label+")<br>";
                    rowData += "Page ("+page+")<br>";
                    rowData += "File ("+file+")<br>";
                    rowData += "URL ("+url+")<br>";
                    return rowData;
                },
                autoHide: false,
                sortable: false,
            },{
                field: 'activity',
                title: 'Activity',
                width: 100,
                template: function(row){
                    var assignment = parseInt(row.assignment);
                    var quiz = parseInt(row.quiz);
                    var forum = parseInt(row.forum);
                    var h5p = parseInt(row.hvp);
                    var active_quiz = parseInt(row.active_quiz);
                    var wiki = parseInt(row.wiki);
                    var chat = parseInt(row.chat);
                    var feedback = parseInt(row.feedback);
                    var vpl = parseInt(row.vpl);

                    var rowData = "Assignment ("+assignment+")<br>";
                    rowData += "Quiz ("+quiz+")<br>";
                    rowData += "Forum ("+forum+")<br>";
                    rowData += "H5P ("+h5p+")<br>";
                    rowData += "Active Quiz ("+active_quiz+")<br>";
                    rowData += "Wiki ("+wiki+")<br>";
                    rowData += "Chat ("+chat+")<br>";
                    rowData += "Feedback ("+feedback+")<br>";
                    rowData += "VPL ("+vpl+")<br>";
                    return rowData;
                },
                autoHide: false,
                sortable: false,
            },{
                field: 'sum',
                title: 'Sum Resource & Activity',
                autoHide: false
            }
        ],
        };
        var refreshParamInput = function(){
            currentFilter = {
                                semester : $("#prodi_semester_filter").val(),
                                faculty_id : $("#prodi_faculty_filter").val(),
                                study_program_id : $("#prodi_study_program_filter").val(),
                            }
            if(reportDt){
                var currentData = reportDt.getOption("data");
                currentData.source.read.params = currentFilter;
            }
        }
        var initDt = function () {
            options.search = {
                input: $('#generalSearch'),
                delay: 100
            };

            $("#prodi_apply_filter").on("click", function () {
                if(!reportDt)
                    reportDt = $('#datatable-prodi').KTDatatable(options);
                else
                    reportDt.reload();

                fetchStatistics();
            });
        };

        var initChart = function() {
            $("#nav-item-prodi").click(function(){
                // fetchStatistics();
            })

            if ($('#kt_chart_subject_statistics_prodi').length == 0 || $('#kt_chart_subject_bar_prodi').length == 0) {
                return;
            }
           
            barChart = Morris.Bar({
                element: 'kt_chart_subject_bar_prodi',
                data: [{}],
                xkey: 'range',
                ykeys: ['studyprogram'],
                labels: ['Jumlah Study Program'],
                barColors: [
                    KTApp.getStateColor('danger'),
                    KTApp.getStateColor('warning'),
                    KTApp.getStateColor('success'),
                    KTApp.getStateColor('primary'),
                ],
                resize: true,
                xLabelAngle: 45
            })
          
            statisticChart = Morris.Donut({
                element: 'kt_chart_subject_statistics_prodi',
                data: [{}],
                colors: [
                    '#f44336',
                    '#E91E63',
                    '#9c27b0',
                    '#673ab7',
                    '#3f51b5',
                    '#2196F3',
                    '#03a9f4',
                    '#00bcd4',
                    '#009688',
                    '#4caf50',
                    '#8bc34a',
                    '#cddc39',
                    '#ffeb3b',
                    '#ffc107'
                ],
            });
        }

        var initFilter = function(){
            $("#prodi_semester_filter,#prodi_faculty_filter,#prodi_study_program_filter").on("change",function(){
                refreshParamInput();
            });

            $("#prodi_faculty_filter").change(function(){
                var facultyId = $(this).val();
                getStudyProgramFilter(facultyId).then(function(){
                    refreshStudyProgramFilter("#prodi_study_program_filter");
                })
            });
        }
        
        var renderStatistics = function(data){
            // table = $('#prodi_range_table')
            // table.empty()

            if(data != false){
                cluster = []
                totalStudyProgram = 0;
                totalChanges = 0;
                for(const [range, studyprogram] of Object.entries(data.cluster)){
                    // table.append(`<tr><td>${range}</td><td>${dosen}</td></tr>`)
                    totalStudyProgram += studyprogram
                    cluster.push({range: range, studyprogram: studyprogram})
                }

                barChart.setData(cluster)
                statistic = data.pie
                totalChanges = statistic.sum
                average = totalChanges / totalStudyProgram
                $('#kt_chart_subject_bar_prodi').next().remove()
                $('#kt_chart_subject_bar_prodi').after('<p>Average Changes: ${average.toFixed(1)} changes per study program</p>')

                if(statistic.sum == 0){
                    labelPercent = '0%'
                    pagePercent = '0%'
                    filePercent = '0%'
                    urlPercent = '0%'
                    assignmentPercent = '0%'
                    quizPercent = '0%'
                    forumPercent = '0%'
                    h5pPercent = '0%'
                    activeQuizPercent = '0%'
                    wikiPercent = '0%'
                    chatPercent = '0%'
                    feedbackPercent = '0%'
                    vplPercent = '0%'
                    viewPercent = '0%'
                }else{
                    labelPercent = ((statistic.label / statistic.sum) * 100).toFixed(2) + '%'
                    pagePercent = ((statistic.page / statistic.sum) * 100).toFixed(2) + '%'
                    filePercent = ((statistic.resource / statistic.sum) * 100).toFixed(2) + '%'
                    urlPercent = ((statistic.url / statistic.sum) * 100).toFixed(2) + '%'
                    assignmentPercent = ((statistic.assignment / statistic.sum) * 100).toFixed(2) + '%'
                    quizPercent = ((statistic.quiz / statistic.sum) * 100).toFixed(2) + '%'
                    forumPercent = ((statistic.forum / statistic.sum) * 100).toFixed(2) + '%'
                    h5pPercent = ((statistic.hvp / statistic.sum) * 100).toFixed(2) + '%'
                    activeQuizPercent = ((statistic.active_quiz / statistic.sum) * 100).toFixed(2) + '%'
                    wikiPercent = ((statistic.wiki / statistic.sum) * 100).toFixed(2) + '%'
                    chatPercent = ((statistic.chat / statistic.sum) * 100).toFixed(2) + '%'
                    feedbackPercent = ((statistic.feedback / statistic.sum) * 100).toFixed(2) + '%'
                    vplPercent = ((statistic.vpl / statistic.sum) * 100).toFixed(2) + '%'
                    viewPercent = ((statistic.course_view / statistic.sum) * 100).toFixed(2) + '%'
                }

                statisticChart.setData([
                    {label: activeQuizPercent, value: statistic.active_quiz},
                    {label: assignmentPercent, value: statistic.assignment},
                    {label: chatPercent, value: statistic.chat},
                    {label: feedbackPercent, value: statistic.feedback},
                    {label: filePercent, value: statistic.resource},
                    {label: forumPercent, value: statistic.forum},
                    {label: h5pPercent, value: statistic.hvp},
                    {label: labelPercent, value: statistic.label},
                    {label: pagePercent, value: statistic.page},
                    {label: quizPercent, value: statistic.quiz},
                    {label: urlPercent, value: statistic.url},
                    {label: vplPercent, value: statistic.vpl},
                    {label: wikiPercent, value: statistic.wiki},
                    {label: viewPercent, value: statistic.course_view},
                ])

                setTimeout(function(){
                    statisticChart.redraw()
                    barChart.redraw()
                },10)

                $("#prodi_percent1").html(statistic.active_quiz.toLocaleString('id-Id')+" active quiz changes");
                $("#prodi_percent2").html(statistic.assignment.toLocaleString('id-Id')+" assignment changes");
                $("#prodi_percent3").html(statistic.chat.toLocaleString('id-Id')+" chat changes");
                $("#prodi_percent4").html(statistic.feedback.toLocaleString('id-Id')+" feedback changes");
                $("#prodi_percent5").html(statistic.resource.toLocaleString('id-Id')+" file changes");
                $("#prodi_percent6").html(statistic.forum.toLocaleString('id-Id')+" forum changes");
                $("#prodi_percent7").html(statistic.hvp.toLocaleString('id-Id')+" h5p changes");
                $("#prodi_percent8").html(statistic.label.toLocaleString('id-Id')+" label changes");
                $("#prodi_percent9").html(statistic.page.toLocaleString('id-Id')+" page changes");
                $("#prodi_percent10").html(statistic.quiz.toLocaleString('id-Id')+" quiz changes");
                $("#prodi_percent11").html(statistic.url.toLocaleString('id-Id')+" url changes");
                $("#prodi_percent12").html(statistic.vpl.toLocaleString('id-Id')+" vpl changes");
                $("#prodi_percent13").html(statistic.wiki.toLocaleString('id-Id')+" wiki changes");
                $("#prodi_percent14").html(statistic.course_view.toLocaleString('id-Id')+" course view");
                $("#prodi_percent15").html(statistic.sum.toLocaleString('id-Id')+" total changes");
            }else{
                barChart.setData([{range: 'range', studyprogram: 0}])
                statisticChart.setData([{label: 'change', value: 0}])
            }


        }

        var fetchStatistics = function(){
            KTApp.blockPage();
            $.ajax({
                type : 'GET',
                url : "<?php echo base_url($controller_full_path."/statistic_study_program"); ?>",
                dataType : "json",
                data : currentFilter,
                success : function(response,status){
                    KTApp.unblockPage();
                    if(response.status == true){
                        renderStatistics(response.data);
                    }else{
                        renderStatistics(false);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown){
                    KTApp.unblockPage();
                    renderStatistics(false);
                }
            });  
        }


        return {
            init: function () {
                initDt();
                initChart();
                initFilter();
                refreshParamInput();
                renderStatistics(false);
            },

        };
    }();

    var reportFaculty = function () {
        // Private functions
        var reportDt = false;
        var currentFilter = false;
        var statisticChart = false;
        var barChart = false
        var options = {
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: "<?php echo base_url($controller_full_path."/datatable_faculty"); ?>",
                        params:{
                            semester : () => {
                                return $("#faculty_semester_filter").val()
                            } ,
                            faculty_id : () => {
                                return $("#faculty_faculty_filter").val()
                            },
                        }
                    }
                },
                pageSize: 10,
                serverSide: true,
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true,
                timeout: 30000,
                saveState:
                    {
                        cookie: false,
                        webstorage: false
                    }
            },

            layout: {
                scroll: true, 
                height: 750, 
                footer: false 
            },
            // column sorting
            sortable: true,
            pagination: true,
            // columns definition
            columns: [ {
                field: 'category_name',
                title: 'Faculty',
            },{
                field: 'course_view',
                title: 'Course View',
                autoHide: false,
            },{
                field: 'resource',
                title: 'Resource',
                width: 100,
                template: function(row){
                    var label = parseInt(row.label);
                    var page = parseInt(row.page);
                    var file = parseInt(row.resource);
                    var url = parseInt(row.url);
                    var rowData = "Label ("+label+")<br>";
                    rowData += "Page ("+page+")<br>";
                    rowData += "File ("+file+")<br>";
                    rowData += "URL ("+url+")<br>";
                    return rowData;
                },
                autoHide: false,
                sortable: false,
            },{
                field: 'activity',
                title: 'Activity',
                width: 100,
                template: function(row){
                    var assignment = parseInt(row.assignment);
                    var quiz = parseInt(row.quiz);
                    var forum = parseInt(row.forum);
                    var h5p = parseInt(row.hvp);
                    var active_quiz = parseInt(row.active_quiz);
                    var wiki = parseInt(row.wiki);
                    var chat = parseInt(row.chat);
                    var feedback = parseInt(row.feedback);
                    var vpl = parseInt(row.vpl);

                    var rowData = "Assignment ("+assignment+")<br>";
                    rowData += "Quiz ("+quiz+")<br>";
                    rowData += "Forum ("+forum+")<br>";
                    rowData += "H5P ("+h5p+")<br>";
                    rowData += "Active Quiz ("+active_quiz+")<br>";
                    rowData += "Wiki ("+wiki+")<br>";
                    rowData += "Chat ("+chat+")<br>";
                    rowData += "Feedback ("+feedback+")<br>";
                    rowData += "VPL ("+vpl+")<br>";
                    return rowData;
                },
                autoHide: false,
                sortable: false,
            },{
                field: 'sum',
                title: 'Sum Resource & Activity',
                autoHide: false
            }
        ],
        };
        var refreshParamInput = function(){
            currentFilter = {
                                semester : $("#faculty_semester_filter").val(),
                                faculty_id : $("#faculty_faculty_filter").val(),
                            }
            if(reportDt){
                var currentData = reportDt.getOption("data");
                currentData.source.read.params = currentFilter;
            }
        }
        var initDt = function () {
            options.search = {
                input: $('#generalSearch'),
                delay: 100
            };
            
            $("#faculty_apply_filter").on("click", function () {
                if(!reportDt)
                    reportDt = $('#datatable-faculty').KTDatatable(options);
                else
                    reportDt.reload();

                fetchStatistics();
            });
        };

        var initChart = function() {

            $("#nav-item-faculty").click(function(){
                // fetchStatistics();
            })

            if ($('#kt_chart_subject_statistics_faculty').length == 0 || $('#kt_chart_subject_bar_faculty').length == 0) {
                return;
            }
            barChart = Morris.Bar({
                element: 'kt_chart_subject_bar_faculty',
                data: [{}],
                xkey: 'range',
                ykeys: ['faculty'],
                labels: ['Jumlah Faculty'],
                barColors: [
                    KTApp.getStateColor('danger'),
                    KTApp.getStateColor('warning'),
                    KTApp.getStateColor('success'),
                    KTApp.getStateColor('primary'),
                ],
                resize: true,
                xLabelAngle: 45
            })

            statisticChart = Morris.Donut({
                element: 'kt_chart_subject_statistics_faculty',
                data: [{}],
                colors: [
                    '#f44336',
                    '#E91E63',
                    '#9c27b0',
                    '#673ab7',
                    '#3f51b5',
                    '#2196F3',
                    '#03a9f4',
                    '#00bcd4',
                    '#009688',
                    '#4caf50',
                    '#8bc34a',
                    '#cddc39',
                    '#ffeb3b',
                    '#ffc107'
                ],
            });
        }

        var initFilter = function(){
            $("#faculty_semester_filter,#faculty_faculty_filter").on("change",function(){
                refreshParamInput();
            });
        }
        
        var renderStatistics = function(data){
            // table = $('#faculty_range_table')
            // table.empty()

            if(data != false){

                cluster = []
                totalFaculty = 0;
                totalChanges = 0;
                for(const [range, faculty] of Object.entries(data.cluster)){
                    // table.append(`<tr><td>${range}</td><td>${dosen}</td></tr>`)
                    totalFaculty += faculty
                    cluster.push({range: range, faculty: faculty})
                }

                barChart.setData(cluster)
                statistic = data.pie
                totalChanges = statistic.sum
                average = totalChanges / totalFaculty
                $('#kt_chart_subject_bar_faculty').next().remove()
                $('#kt_chart_subject_bar_faculty').after('<p>Average Changes: ${average.toFixed(1)} changes per faculty</p>')

                if(statistic.sum == 0){
                    labelPercent = '0%'
                    pagePercent = '0%'
                    filePercent = '0%'
                    urlPercent = '0%'
                    assignmentPercent = '0%'
                    quizPercent = '0%'
                    forumPercent = '0%'
                    h5pPercent = '0%'
                    activeQuizPercent = '0%'
                    wikiPercent = '0%'
                    chatPercent = '0%'
                    feedbackPercent = '0%'
                    vplPercent = '0%'
                    viewPercent = '0%'
                }else{
                    labelPercent = ((statistic.label / statistic.sum) * 100).toFixed(2) + '%'
                    pagePercent = ((statistic.page / statistic.sum) * 100).toFixed(2) + '%'
                    filePercent = ((statistic.resource / statistic.sum) * 100).toFixed(2) + '%'
                    urlPercent = ((statistic.url / statistic.sum) * 100).toFixed(2) + '%'
                    assignmentPercent = ((statistic.assignment / statistic.sum) * 100).toFixed(2) + '%'
                    quizPercent = ((statistic.quiz / statistic.sum) * 100).toFixed(2) + '%'
                    forumPercent = ((statistic.forum / statistic.sum) * 100).toFixed(2) + '%'
                    h5pPercent = ((statistic.hvp / statistic.sum) * 100).toFixed(2) + '%'
                    activeQuizPercent = ((statistic.active_quiz / statistic.sum) * 100).toFixed(2) + '%'
                    wikiPercent = ((statistic.wiki / statistic.sum) * 100).toFixed(2) + '%'
                    chatPercent = ((statistic.chat / statistic.sum) * 100).toFixed(2) + '%'
                    feedbackPercent = ((statistic.feedback / statistic.sum) * 100).toFixed(2) + '%'
                    vplPercent = ((statistic.vpl / statistic.sum) * 100).toFixed(2) + '%'
                    viewPercent = ((statistic.course_view / statistic.sum) * 100).toFixed(2) + '%'
                }

                statisticChart.setData([
                    {label: activeQuizPercent, value: statistic.active_quiz},
                    {label: assignmentPercent, value: statistic.assignment},
                    {label: chatPercent, value: statistic.chat},
                    {label: feedbackPercent, value: statistic.feedback},
                    {label: filePercent, value: statistic.resource},
                    {label: forumPercent, value: statistic.forum},
                    {label: h5pPercent, value: statistic.hvp},
                    {label: labelPercent, value: statistic.label},
                    {label: pagePercent, value: statistic.page},
                    {label: quizPercent, value: statistic.quiz},
                    {label: urlPercent, value: statistic.url},
                    {label: vplPercent, value: statistic.vpl},
                    {label: wikiPercent, value: statistic.wiki},
                    {label: viewPercent, value: statistic.course_view},
                ])

                setTimeout(function(){
                    statisticChart.redraw()
                    barChart.redraw()
                },10)

                $("#faculty_percent1").html(statistic.active_quiz.toLocaleString('id-Id')+" active quiz changes");
                $("#faculty_percent2").html(statistic.assignment.toLocaleString('id-Id')+" assignment changes");
                $("#faculty_percent3").html(statistic.chat.toLocaleString('id-Id')+" chat changes");
                $("#faculty_percent4").html(statistic.feedback.toLocaleString('id-Id')+" feedback changes");
                $("#faculty_percent5").html(statistic.resource.toLocaleString('id-Id')+" file changes");
                $("#faculty_percent6").html(statistic.forum.toLocaleString('id-Id')+" forum changes");
                $("#faculty_percent7").html(statistic.hvp.toLocaleString('id-Id')+" h5p changes");
                $("#faculty_percent8").html(statistic.label.toLocaleString('id-Id')+" label changes");
                $("#faculty_percent9").html(statistic.page.toLocaleString('id-Id')+" page changes");
                $("#faculty_percent10").html(statistic.quiz.toLocaleString('id-Id')+" quiz changes");
                $("#faculty_percent11").html(statistic.url.toLocaleString('id-Id')+" url changes");
                $("#faculty_percent12").html(statistic.vpl.toLocaleString('id-Id')+" vpl changes");
                $("#faculty_percent13").html(statistic.wiki.toLocaleString('id-Id')+" wiki changes");
                $("#faculty_percent14").html(statistic.course_view.toLocaleString('id-Id')+" course view");
                $("#faculty_percent15").html(statistic.sum.toLocaleString('id-Id')+" total changes");
            }else{
                barChart.setData([{range: 'range', faculty: 0}])
                statisticChart.setData([{label: 'change', value: 0}])
            }

        }

        var fetchStatistics = function(){
            KTApp.blockPage();
            $.ajax({
                type : 'GET',
                url : "<?php echo base_url($controller_full_path."/statistic_faculty"); ?>",
                dataType : "json",
                data : currentFilter,
                success : function(response,status){
                    KTApp.unblockPage();
                    if(response.status == true){
                        renderStatistics(response.data);
                    }else{
                        renderStatistics(false);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown){
                    KTApp.unblockPage();
                    renderStatistics(false);
                }
            });  
        }


        return {
            init: function () {
                initDt();
                initDTEvents();
                initChart();
                initFilter();
                refreshParamInput();
                renderStatistics(false);
            },

        };
    }();

    var mySubjects = [];
    var myStudyProgram = [];
    var myFaculty = [];

    function getFacultyFilter(){
        var promise = new Promise(function(resolve, reject) {
            KTApp.blockPage();
            $.ajax({
                type : 'GET',
                url : "<?php echo base_url($controller_full_path."/get_my_faculty"); ?>",
                dataType : "json",
                success : function(response,status){
                    KTApp.unblockPage();
                    myFaculty = response.data
                    resolve(myFaculty);
                },
                error: function (jqXHR, textStatus, errorThrown){
                    KTApp.unblockPage();
                    reject(errorThrown);
                }
            });  
        });
        return promise;
    }

    function getStudyProgramFilter(facultyId){
        var promise = new Promise(function(resolve, reject) {
            KTApp.blockPage();
            $.ajax({
                type : 'GET',
                url : "<?php echo base_url($controller_full_path."/get_my_study_program"); ?>?faculty_id="+facultyId,
                dataType : "json",
                success : function(response,status){
                    KTApp.unblockPage();
                    myStudyProgram = response.data
                    resolve(myStudyProgram);

                },
                error: function (jqXHR, textStatus, errorThrown){
                    KTApp.unblockPage();
                    reject(errorThrown);
                }
            });
        });
        return promise;
    }

    function getSubjectFilter(studyProgramId,semester){
        var promise = new Promise(function(resolve, reject) {
            KTApp.blockPage();
            $.ajax({
                type : 'GET',
                url : "<?php echo base_url($controller_full_path."/get_cource_change_subject"); ?>?study_program_id="+studyProgramId+"&semester="+semester,
                dataType : "json",
                success : function(response,status){
                    KTApp.unblockPage();
                    mySubjects = response.data
                    resolve(mySubjects);            
                },
                error: function (jqXHR, textStatus, errorThrown){
                    KTApp.unblockPage();
                    reject(errorThrown);
                }
            });  
        });
        return promise;
    }

    function initFilters(){
        $(".year_filter").select2({
            placeholder: "All",
            width: '100%'
        });
        $(".semester_filter").select2({
            placeholder: "All",
            width: '100%'
        });
        $(".study_program_filter").select2({
            placeholder: "All",
            width: '100%'
        });
        $(".subject_filter").select2({
            placeholder: "All",
            width: '100%'
        });
        $(".approval_status_filter").select2({
            placeholder: "All",
            width: '100%'
        });
        $(".faculty_filter").select2({
            placeholder: "All",
            width: '100%'
        });
        $(".teacher_filter").select2({
            placeholder: "All",
            width: '100%'
        });

        refreshFacultyFilter();
        refreshStudyProgramFilter();
        refreshSubjectFilter();
    }

    function refreshFacultyFilter(elementId){
        if(elementId == undefined){
            elementId = ".faculty_filter";
        }
        var defaultFaculty = new Option("All Faculty", 0, true, true);
        //faculty
        $(elementId).empty();
        $(elementId).select2('data', {id: null, text: null})
        $(elementId).append(defaultFaculty);
        for (var i = 0; i < myFaculty.length; i++) {
            var data =  myFaculty[i];
            var newOption = new Option(data.category_name, data.category_id, false, false);
            $(elementId).append(newOption);
        }
        $(elementId).trigger("change");

    }

    function refreshStudyProgramFilter(elementId){
        if(elementId == undefined){
            elementId = ".study_program_filter";
        }
        //program study
        var defaultStudyProgram = new Option("All Study Program", 0, true, true);
        $(elementId).empty();
        $(elementId).select2('data', {id: null, text: null})
        $(elementId).append(defaultStudyProgram);
        for (var i = 0; i < myStudyProgram.length; i++) {
            var data =  myStudyProgram[i];
            var newOption = new Option(data.category_name, data.category_id, false, false);
            $(elementId).append(newOption);
        }
        $(elementId).trigger("change");
    }

    function refreshSubjectFilter(elementId){
        if(elementId == undefined){
            elementId = ".subject_filter";
        }
        //subject
        var defaultSubject = new Option("All Subject", 0, true, true);
        $(elementId).empty();
        $(elementId).select2('data', {id: null, text: null})
        $(elementId).append(defaultSubject);
        for (var i = 0; i < mySubjects.length; i++) {
            var data =  mySubjects[i];
            var newOption = new Option(data.subject_name+" ("+data.subject_code+")", data.subject_code, false, false);
            $(elementId).append(newOption);
        }
        $(elementId).trigger("change");
    }

    function Export(type){
        <?php if($privilege->can_read && $clearance_level >= 1){?>
        if (type !== null){
            var prefix = "";
            var list = {"mk":"Per_Teacher","prodi":"Per_Study_Program","faculty":"Per_Faculty"};
            prefix = list[type];
            if (prefix !== null){
                KTApp.blockPage();
                var currdate = new Date();
                var date = moment(currdate).format('YYYY-MM-DD H:mm:s');
                var filename = "Report_Teacher_Activities_"+prefix+"_"+date+".csv";
                var filter = {};
                filter['type'] = type;
                $("#"+type+"_filter").find("select").each(function(){
                    filter[$(this).attr("id")] = $(this).val();
                });
                $.ajax({
                    url: "<?php echo base_url($controller_full_path."/export");?>",
                    type: 'post',
                    dataType: 'html',
                    data: JSON.stringify(filter),
                    success: function(data) {
                        KTApp.unblockPage();
                        var downloadLink = document.createElement("a");
                        var fileData = ['\ufeff'+data];
                        var blobObject = new Blob(fileData,{type: "text/csv;charset=utf-8;"});
                        var url = URL.createObjectURL(blobObject);
                        downloadLink.href = url;
                        downloadLink.download = filename;
                        document.body.appendChild(downloadLink);
                        downloadLink.click();
                        document.body.removeChild(downloadLink);
                    }
                })
            }
            else {
                swal.fire({
                    title: 'Infomation',
                    text: "Unidentified export parameter",
                    type: 'info',
                });
            }
        <?php }else{ ?>
        swal.fire({
            title: 'Infomation',
            text: "You cannot export this data",
            type: 'info',
        });
        <?php } ?>
        }
    }

    $(document).ready(function(){
        getFacultyFilter().finally(function () {
           getStudyProgramFilter(0).finally(function () {
                getSubjectFilter(0,0).finally(function () {
                    initFilters();
					reportSubject.init();
                })
            })
        })
    });
