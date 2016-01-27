{!! Form::open(array('url' => 'institute', 'class' => 'form', 'role' => 'form')) !!}
                            {!! Form::text('givenInstituteName', null, ['class' => 'input  form-control', 'placeholder' => 'Institute Name...']) !!}
                            {!! Form::text('numberOFClasses', null, ['class' => 'input  form-control', 'placeholder' => 'Number of classes...']) !!}
                            {!! Form::text('nobelLaureates', null, ['class' => 'input  form-control', 'placeholder' => 'Number of Nobel Laureats...']) !!}
                            {!! Form::text('academicStaff', null, ['class' => 'input  form-control', 'placeholder' => 'Number of Academic staf...']) !!}
                            {!! Form::text('locations', null, ['class' => 'input  form-control', 'placeholder' => 'Number of locations available...']) !!}
                            {!! Form::text('students', null, ['class' => 'input  form-control', 'placeholder' => 'Number of students...']) !!}
                            {!! Form::text('offeredClass, null, ['class' => 'input  form-control', 'placeholder' => 'Offered class...']) !!}
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