<link href="<?php echo base_url(); ?>assets/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">                                
     <!-- begin:: Content Head -->
     <div class="kt-subheader  kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">                
                <h3 class="kt-subheader__title"><?php echo $breadcrumb->parent;?></h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <span class="kt-subheader__desc"><?php echo $breadcrumb->child;?></span>       
            </div>
        <div class="kt-subheader__toolbar">
            <div class="kt-subheader__wrapper">
            </div>
            </div>
        </div>
    </div>
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
		<div class="kt-portlet__body" style="">                   
			<div class="tab-content">
				<div class="tab-pane" id="faculty_content" role="tabpanel">     

					<div class="col-md-pull-12 col-xl-pull-12" >                    
						<div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
							<div class="row align-items-center" id="mk_filter">
								<div class="col-xl-2 col-md-2">
									<div class="form-group">
										<label>Semester</label>
										<select class="form-control semester_filter" id="mk_semester_filter">
											<option value="0">All Semester</option>
											<?php foreach($semester_filter_data as $semester_filter){?>
												<option value="<?php echo $semester_filter->semester;?>"><?php echo $semester_filter->semester;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								 <div class="col-xl-2 col-md-2">
									<div class="form-group">
										<label>Study Program</label>
										<select class="form-control study_program_filter" id="mk_study_program_filter">
										</select>
									</div>
								</div>
								<div class="col-xl-2 col-md-2">
									<div class="form-group">
										<label>Subject</label>
										<select class="form-control subject_filter" id="mk_subject_filter">
										</select>
									</div>
								</div>
								<div class="col-xl-2 col-md-2">
									<div class="form-group">
										<label>Teacher</label>
										<select class="form-control teacher_filter" id="mk_teacher_filter">
											<option value="0">All Teacher</option>
											<?php foreach($teachers as $teacher): ?>
												<option value="<?= $teacher->username ?>"><?= $teacher->name ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
							
							<button type="button" id="mk_apply_filter" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
						</div>    
						<div class="kt-form kt-form--label-right">
							<div class="row align-items-center">
								<div class="col-xl-12 order-2 order-xl-1">
									<div class="row align-items-center">                   
										<div class="col-md-12">
											<div class="pull-right">
												<?php if($privilege->can_read && $clearance_level >= 1){?>
													<button type="button" class="btn btn-success btn-icon-sm" onclick="Export('mk')">
														<i class="flaticon2-file"></i> Export CSV      
													</button> 
												<?php } ?>
											</div>
										</div>           
									</div>
								</div>      
							</div>
						</div>      
					</div>
					<div class="kt-datatable" id="datatable-subject"></div>

					<div class="kt-portlet">
						<div class="kt-portlet__head">
							<div class="kt-portlet__head-label">
								<h3 class="kt-portlet__head-title">Change Summary</h3>
							</div>
						</div>
						<div class="kt-portlet__body">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<div class="kt-section">
										<h5 class="kt-section__info">Statistics</h5>
										<div class="kt-section__content kt-section__content">
											<div id="kt_chart_subject_bar"></div>
										</div>
									</div>
								</div>
								<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
									<div class="kt-section">
										<h5 class="kt-section__info">Aggregate</h5>
										<div class="kt-section__content kt-section__content">
											<div class="kt-portlet kt-portlet--height-fluid">
												<div class="kt-widget14">
													<div class="kt-widget14__header">
														<h3 class="kt-widget14__title">
														</h3>
													</div>
													<div class="kt-widget14__content">
														<div class="kt-widget14__chart">
															<div id="kt_chart_subject_statistics" style="height: 150px; width: 150px;"></div>
														</div>           
														<div class="kt-widget14__legends">
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet" style="background-color: #f44336"></span>
																<span id="mk_percent1" class="kt-widget14__stats">-</span>
															</div>
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet" style="background-color: #E91E63"></span>
																<span id="mk_percent2" class="kt-widget14__stats">-</span>
															</div>
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet" style="background-color: #9c27b0"></span>
																<span id="mk_percent3" class="kt-widget14__stats">-</span>
															</div>
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet" style="background-color: #673ab7"></span>
																<span id="mk_percent4" class="kt-widget14__stats">-</span>
															</div>
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet" style="background-color: #3f51b5"></span>
																<span id="mk_percent5" class="kt-widget14__stats">-</span>
															</div>
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet" style="background-color: #2196F3"></span>
																<span id="mk_percent6" class="kt-widget14__stats">-</span>
															</div>
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet" style="background-color: #03a9f4"></span>
																<span id="mk_percent7" class="kt-widget14__stats">-</span>
															</div>
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet" style="background-color: #00bcd4"></span>
																<span id="mk_percent8" class="kt-widget14__stats">-</span>
															</div>
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet" style="background-color: #009688"></span>
																<span id="mk_percent9" class="kt-widget14__stats">-</span>
															</div>
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet" style="background-color: #4caf50"></span>
																<span id="mk_percent10" class="kt-widget14__stats">-</span>
															</div>
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet" style="background-color: #8bc34a"></span>
																<span id="mk_percent11" class="kt-widget14__stats">-</span>
															</div>
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet" style="background-color: #cddc39"></span>
																<span id="mk_percent12" class="kt-widget14__stats">-</span>
															</div>
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet" style="background-color: #ffeb3b"></span>
																<span id="mk_percent13" class="kt-widget14__stats">-</span>
															</div>
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet" style="background-color: #ffc107"></span>
																<span id="mk_percent14" class="kt-widget14__stats">-</span>
															</div>
															<div class="kt-widget14__legend">
																<span class="kt-widget14__bullet"></span>
																<span id="mk_percent15" class="kt-widget14__stats">-</span>
															</div>
														</div>      
													</div>   
												</div>
											</div>  
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>                    
			</div>      
		</div>
	</div>
</div>