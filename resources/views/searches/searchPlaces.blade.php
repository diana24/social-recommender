<div class="col-md-5">
			{!! Form::label('Search Places') !!}
			{!! Form::open(array('url' => 'search/places', 'class' => 'search-form', 'role' => 'form', 'method'=>'get')) !!}
			<div class="row">
					<div class="col-md-12">
						{!! Form::label('Place name') !!}
						<div class="form-group">{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => ' Place name..']) !!}
						</div>
					 </div>
					<div class="col-md-12">
						{!! Form::label('Place Type') !!}
						<div class="form-group">{!! Form::text('getPlaceTypes', null, ['class' => 'form-control', 'placeholder' => ' Place type..']) !!}
					</div>
					</div> 
					<div class="col-md-12">
						{!! Form::label('Country') !!}
						<div class="form-group">{!! Form::text('getCountries', null, ['class' => 'form-control', 'placeholder' => ' Country..']) !!}
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