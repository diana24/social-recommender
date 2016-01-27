<div class="col-md-5">
			{!! Form::label('Search Persons') !!}
			{!! Form::open(array('url' => 'search/people', 'class' => 'search-form', 'role' => 'form', 'method'=>'get')) !!}
			<div class="row">
					<div class="col-md-12">
						{!! Form::label('First name') !!}
						<div class="form-group">{!! Form::text('personfirstName', null, ['class' => 'form-control', 'placeholder' => ' First name..']) !!}
						</div>
					</div>
					<div class="col-md-12">
						{!! Form::label('Last name') !!}
						<div class="form-group">{!! Form::text('personlastName', null, ['class' => 'form-control', 'placeholder' => 'Last name..']) !!}
						</div>
					</div>
					<div class="col-md-12">
						{!! Form::label('Birth place') !!}
						<div class="form-group">
						{!! Form::text('personBirthPlace', null, ['class' => 'form-control', 'placeholder' => 'Birth place..']) !!}
						</div>
					</div>
					<div class="col-md-12">
						{!! Form::label('Profession') !!}
						<div class="form-group">{!! Form::text('personProffesion', null, ['class' => 'form-control', 'placeholder' => 'Profession..']) !!}
						</div>
					</div>
					<div class="col-md-12">
						{!! Form::label('Country') !!}
						<div class="form-group">{!! Form::text('personCountry', null, ['class' => 'form-control', 'placeholder' => 'Country..']) !!}
						</div>
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