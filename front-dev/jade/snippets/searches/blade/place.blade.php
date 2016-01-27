{!! Form::open(array('url' => 'place', 'class' => 'form', 'role' => 'form')) !!}
                            {!! Form::text('placeName', null, ['class' => 'input form-control', 'placeholder' => 'Place name...']) !!}
                            
                            {!! Form::text('placeCountry', null, ['class' => 'input  form-control', 'placeholder' => 'Country...']) !!}
                            {{ Form::Label('ranking_id','Ranking:') }}
                            {{ Form::select('ranking_id', array(
                             '',
                            '2'=>'1',
                            '3'=>'2',
                            '4'=>'3',
                            '5'=>'4',
                            '6'=>'5'
                            ),'5') }}
                            {!! Form::submit('Search',  ['class' => 'Search']) !!}
                        {!! Form::close() !!}