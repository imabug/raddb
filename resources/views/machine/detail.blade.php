<!-- resources/views/machine/detail.blade.php -->

@extends('layouts.app')

@section('content')
<h2>Machine Information</h2>

@include('machine.info')
@include('machine.tubes')
@include('machine.opnotes')
@include('machine.surveys')
@include('machine.recs')

<script type="text/javascript">
    $(document).ready(function(){
        $('.multiple-items').slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            dots: true,
            pauseOnDotsHover: true
        });
    });
</script>
@endsection
