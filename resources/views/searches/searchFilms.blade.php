<div class="col-md-5">
			{!! Form::label('Search Movies') !!}
			{!! Form::open(array('url' => 'search/films', 'class' => 'search-form', 'role' => 'form', 'method'=>'get')) !!}
			<div class="row">
					<div class="col-md-12">
						{!! Form::label('Movie name') !!}
						<div class="form-group">{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => ' Movie name..']) !!}
						</div>
					 </div>
					<div class="col-md-12">
						{!! Form::label('Director name') !!}
						<div class="form-group">{!! Form::text('getDirectors', null, ['class' => 'form-control', 'placeholder' => ' Director name..']) !!}
						</div>
					</div> 
					<div class="col-md-12">
						{!! Form::label('Actor name') !!}
						<div class="form-group">{!! Form::text('getActors', null, ['class' => 'form-control', 'placeholder' => ' Actor name..']) !!}
						</div>
					</div> 
					<div class="col-md-12">
						{!! Form::label('Musical artist name') !!}
						<div class="form-group">{!! Form::text('getMusicalArtists', null, ['class' => 'form-control', 'placeholder' => ' Musical artist name..']) !!}
						</div>
					</div> 
					 <div class="col-md-12">
						{!! Form::label('Original Language') !!}
						<div class="form-group">{!! Form::text('getLanguages', null, ['class' => 'form-control', 'placeholder' => ' Original Language..']) !!}
						</div>
					</div> 
					<div class="col-md-12">
						{!! Form::label('Country') !!}
						<div class="form-group">{!! Form::text('getCountries', null, ['class' => 'form-control', 'placeholder' => ' Country..']) !!}
						</div>
					</div> 
					<div class="col-md-12">
						{!! Form::label('Movie genre') !!}
						<div class="form-group">{!! Form::text('getMovieGenres', null, ['class' => 'form-control', 'placeholder' => ' Movie genre..']) !!}
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