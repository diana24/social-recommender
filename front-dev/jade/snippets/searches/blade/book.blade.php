{!! Form::open(array('url' => 'book', 'class' => 'form', 'role' => 'form')) !!}
                            {!! Form::text('bookTitle', null, ['class' => 'input  form-control', 'placeholder' => 'Book title...']) !!}
                            {!! Form::text('authorName', null, ['class' => 'input form-control', 'placeholder' => 'Author name...']) !!}
                            {!! Form::text('rleaseDate', null, ['class' => 'input form-control', 'placeholder' => 'Release date...']) !!}
                            {{ Form::Label('literaryGenre','Literary Genre:') }}
                            {{ Form::select('literaryGenre', array(
                             '',
                            '2'=>'Comedy',
                            '3'=>'Drama'
                            '4'=>'Non-fiction'
                            '5'=>'Realistic fiction'
                            '6'=>'Romance Novel'
                            '7'=>'Satire'
                            '8'=>'Tragedy'
                            '9'=>'Tragicomedy'
                            ),'8') }}
                            {!! Form::text('numberOFPagesMin', null, ['class' => 'input  form-control', 'placeholder' => 'Number of minimum pages...']) !!}
                            {!! Form::text('numberOFPagesMax', null, ['class' => 'input  form-control', 'placeholder' => 'Number of maximum pages...']) !!}
                            {!! Form::text('numberOFVolums', null, ['class' => 'input  form-control', 'placeholder' => 'Number of Volums...']) !!}
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
                            {!! Form::submit('Search',  ['class' => 'btn']) !!}
                        {!! Form::close() !!}