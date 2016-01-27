<div class="col-md-5">
			{!! Form::label('Search Books') !!}
			{!! Form::open(array('url' => 'search/books', 'class' => 'search-form', 'role' => 'form', 'method'=>'get')) !!}
			<div class="row">
					<div class="col-md-12">
						{!! Form::label('Book title') !!}
						<div class="form-group">{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => ' Book name..']) !!}
						</div>
					 </div>
					<div class="col-md-12">
						{!! Form::label('Author') !!}
						<div class="form-group">{!! Form::text('getAuthors', null, ['class' => 'form-control', 'placeholder' => ' Author name..']) !!}
						</div>
					 </div>
					 <div class="col-md-12">
						{!! Form::label('Illustrator') !!}
						<div class="form-group">{!! Form::text('getIllustrators', null, ['class' => 'form-control', 'placeholder' => ' Illustrator name..']) !!}
						</div>
					 </div>
					 <div class="col-md-12">
						{!! Form::label('Literary Genres') !!}
						<div class="form-group">{{ Form::select('getLiteraryGenres ', array(
                             '',
                            '2'=>'Comedy',
                            '3'=>'Drama',
                            '4'=>'Non-fiction',
                            '5'=>'Realistic fiction',
                            '6'=>'Romance Novel',
                            '7'=>'Satire',
                            '8'=>'Tragedy',
                            '9'=>'Tragicomedy'
                            ),'8') }}
						</div>
					  {!! Form::label('Number of Pages') !!}
					  </div>
					  
					  <div class="col-md-6 col-sm-6 col-xs-6">
						{!! Form::label('From:') !!}
						<div class="form-group"> 
						{!! Form::text('numberOfPagesMin', null, ['class' => 'input form-control', 'placeholder' => 'Number of minimum pages...']) !!}
						</div>
					  </div>
					  <div class="col-md-6 col-sm-6 col-xs-6">
						{!! Form::label('To:') !!}
						<div class="form-group"> 
						{!! Form::text('numberOfPagesMax', null, ['class' => 'input form-control', 'placeholder' => 'Number of maximum pages...']) !!}
						</div>
					  </div>
					  <div class="col-md-12">
						{!! Form::label('Number of Volumes') !!}
							<div class="form-group">
							{!! Form::text('numberOfVolums', null, ['class' => 'input form-control', 'placeholder' => 'Number of Volumes...']) !!}
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