{!! Form::open(array('url' => 'event', 'class' => 'form', 'role' => 'form')) !!}
                            {!! Form::text('eventName', null, ['class' => 'input  form-control', 'placeholder' => 'Event Name...']) !!}
                            {!! Form::text('eventType', null, ['class' => 'input  form-control', 'placeholder' => 'Event Type...']) !!}
                             
                            {{ Form::Label('ranking_id','Ranking:') }}
                            {{ Form::select('ranking_id', array(
                             '',
                            '2'=>'1',
                            '3'=>'2'
                            '4'=>'3'
                            '5'=>'4'
                            '6'=>'5'
                            ),'5') }}
                            {!! Form::submit('Search',  ['class' => 'Search']) !!}
                        {!! Form::close() !!}