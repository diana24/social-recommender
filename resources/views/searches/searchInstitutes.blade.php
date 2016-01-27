<div class="col-md-5">
			{!! Form::label('Search Educational Institutes') !!}
			{!! Form::open(array('url' => 'search/edu', 'class' => 'search-form', 'role' => 'form', 'method'=>'get')) !!}
			<div class="row">
					<div class="col-md-12">
						{!! Form::label('Institute name') !!}
						<div class="form-group">{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => ' Institute name..']) !!}
						</div>
					 </div>
					<div class="col-md-12">
						{!! Form::label('Educational Institute Type') !!}
						<div class="form-group">{!! Form::text('getEduInstitutionTypes', null, ['class' => 'form-control', 'placeholder' => ' Educational Institute type..']) !!}
					</div>
					</div> 
					<div class="col-md-12">
						{!! Form::label('Location') !!}
						<div class="form-group">{!! Form::text('getLocations', null, ['class' => 'form-control', 'placeholder' => ' Location..']) !!}
						</div>
					</div> 
					<div class="col-md-12">
						{!! Form::label('Country') !!}
						<div class="form-group">{!! Form::text('getCountries', null, ['class' => 'form-control', 'placeholder' => ' Country..']) !!}
						</div>
					</div> 
					<div class="col-md-12">
						{!! Form::label('Principal') !!}
						<div class="form-group">{!! Form::text('getPrincipals', null, ['class' => 'form-control', 'placeholder' => ' Principal name..']) !!}
						</div>
					</div> 
					
					<div class="col-md-12">
						{!! Form::label('Rectors') !!}
						<div class="form-group">{!! Form::text('getRectors', null, ['class' => 'form-control', 'placeholder' => ' Rector..']) !!}
						</div>
					</div> 
					
					<div class="col-md-12">				 
						{!! Form::label('Number of Academic staff:') !!}
				    </div>
					    <div class="col-md-6 col-sm-6 col-xs-6">
							  {!! Form::label('From:') !!}
							 <div class="form-group"> 
								{!! Form::text('nrOfAcademicStaffMin', null, ['class' => 'form-control', 'placeholder' => ' Min number of academic staff..']) !!}
							  </div>
					     </div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							{!! Form::label('to:') !!}
							 <div class="form-group"> 
							 {!! Form::text('nrOfAcademicStaffMax', null, ['class' => 'form-control', 'placeholder' => ' Max number of academic staff..']) !!}
							 </div>
						 </div>
						<div class="col-md-12">				 
						{!! Form::label('Number of Students:') !!}
				    </div>
					    <div class="col-md-6 col-sm-6 col-xs-6">
							  {!! Form::label('From:') !!}
							 <div class="form-group"> 
								{!! Form::text('nrOfStudentsMin', null, ['class' => 'form-control', 'placeholder' => ' Min number of students..']) !!}
							  </div>
					     </div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							{!! Form::label('to:') !!}
							 <div class="form-group"> 
							 {!! Form::text('nrOfStudentsMax', null, ['class' => 'form-control', 'placeholder' => ' Max number of students..']) !!}
							 </div>
						 </div>
					
				 	<div class="col-md-12">				 
						{!! Form::label('Ranking:') !!}
				    </div>
					    <div class="col-md-6 col-sm-6 col-xs-6">
							  {!! Form::label('From:') !!}
							 <div class="form-group"> 
								{{ Form::select('ranking_id_from', array(
								 '',
								'2'=>'1',
								'3'=>'2',
								'4'=>'3',
								'5'=>'4',
								'6'=>'5'
								),'5') }}
							  </div>
					     </div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							{!! Form::label('to:') !!}
							 <div class="form-group"> 
							 {{ Form::select('ranking_id_to', array(
								 '',
								'2'=>'1',
								'3'=>'2',
								'4'=>'3',
								'5'=>'4',
								'6'=>'5'
								),'5') }}
							 </div>
						 </div>
				 
				
						<div class="col-md-12 col-sm-12 col-xs-12 text-right">
							<div class="form-group">{!! Form::submit('Search',  ['class' => 'btn']) !!}
							</div>
						</div>
			</div>
				{!! Form::close() !!}
		</div>