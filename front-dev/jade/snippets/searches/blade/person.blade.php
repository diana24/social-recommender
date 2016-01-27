{!! Form::open(array('url' => 'person', 'class' => 'form', 'role' => 'form')) !!}
                            {!! Form::text('personFirstName', null, ['class' => 'input  form-control', 'placeholder' => 'First Name...']) !!}
                            {!! Form::text('personLastName', null, ['class' => 'input  form-control', 'placeholder' => 'Last Name...']) !!}
                            {!! Form::text('personBirthPlace', null, ['class' => 'input  form-control', 'placeholder' => 'Birth Place...']) !!}
                            {!! Form::text('personProfession', null, ['class' => 'input  form-control', 'placeholder' => 'Profession...']) !!}
                            {!! Form::text('personCountry', null, ['class' => 'input  form-control', 'placeholder' => 'Country...']) !!}
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