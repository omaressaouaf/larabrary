<form autocomplete="off" id="searchAutoForm" action="{{route('library.search')}}" method="GET">
    @include('includes.alerts')
    <div class="input-group ">
        <input type="text" required name="search_query" id="search_query" placeholder="Search For Any Book"
            class="form-control">

        <span class="input-group-btn">
            <button type="submit" class="btn btn-primary-schema "> <i class="fa fa-search"></i></button>
        </span>

    </div>

    <div class="searchAutoDiv">
    </div>

</form>