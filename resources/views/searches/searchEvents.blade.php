<div class="col-md-5">
			{!! Form::label('Search Events') !!}
			{!! Form::open(array('url' => 'search/events', 'class' => 'search-form', 'role' => 'form', 'method'=>'get')) !!}
			<div class="row">
					<div class="col-md-12">
						{!! Form::label('Event name') !!}
						<div class="form-group">{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => ' Event name..']) !!}
						</div>
					 </div>
					<div class="col-md-12">
						{!! Form::label('Event Type') !!}
						<div class="form-group">{!! Form::text('getEventTypes', null, ['class' => 'form-control', 'placeholder' => ' Event types..']) !!}
						</div>
					 
					  {!! Form::label('Start date') !!}
					  </div>
					  
					  <div class="col-md-6 col-sm-6 col-xs-6">
						 
						<div class="form-group"> 
						{!! Form::text('startDateMin', null, ['class' => 'input form-control', 'placeholder' => 'Min start date...']) !!}
						</div>
					   </div>
					   <div class="col-md-6 col-sm-6 col-xs-6">
						 
						 <div class="form-group"> 
						 {!! Form::text('startDateMax', null, ['class' => 'input form-control', 'placeholder' => 'Max start date...']) !!}
						</div>
					   </div>
					  <div class="col-md-12">
					  {!! Form::label('End date') !!}
					  </div>
					   <div class="col-md-6 col-sm-6 col-xs-6">
						 
						<div class="form-group"> 
						{!! Form::text('endDateMin', null, ['class' => 'input form-control', 'placeholder' => 'Min end date...']) !!}
						</div>
					   </div>
					   <div class="col-md-6 col-sm-6 col-xs-6">
						 
						 <div class="form-group"> 
						 {!! Form::text('endDateMax', null, ['class' => 'input form-control', 'placeholder' => 'Max end date...']) !!}
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