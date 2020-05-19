<div class="border p-2">
<form method="POST" action="{{ route('documents.filter') }}" enctype="multipart/form-data" class="py-2"> @csrf
    <div class="row">
        <div class="col-sm" id="Nome/Descricao">
            Nome/Descricão:
            <input
                class="form-control col-sm-12"
                type="text" name="word" id="word"
                value="{{ request()->input('word') }}">
        </div>

        <div class="col-sm" id="Categorias">
            Categorias:<br>
            <a class="nav-link dropdown-toggle"
               id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Selecione...
            </a>

            <ul class="dropdown-menu">
                <li><div class="checkbox">
                        <label>
                            @forelse($categories as $category)
                                <div class="col-sm">
                                    <label class="checkbox-inline">
                                        <input
                                            type="checkbox" value=" {{ $category->id }} "
                                            id="categories" name="categories[]"
                                            style="transform: scale(1.5);"
                                            placeholder="Selecionado">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @empty
                                <p><h5>Nao ha categorias cadastradas</h5></p>
                            @endforelse
                        </label>
                    </div></li>
            </ul>
        </div>

        <div class="col-sm-4" id="Data Publicacao">
            <i class="fas fa-calendar p-2"></i>Data de Publicacao:<br>
            <label class="px-1 small">De</label>
            <input
                name="first_date" id="first_date" type="date"
                data-display-mode="inline" data-is-range="true" data-close-on-select="false"
                value="{{ request()->input('first_date') }}">
            <label class="px-1 small">a</label>
            <input
                name="last_date" id="last_date" type="date"
                data-display-mode="inline" data-is-range="true" data-close-on-select="false"
                value="{{ request()->input('last_date') }}">
        </div>

        <div class="col-sm" id="Tags">
            Tags: <br>
            <a class="nav-link dropdown-toggle"
               id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Selecione...
            </a>

            <ul class="dropdown-menu">

                <li><div class="checkbox">

                <label>

                    <!--<input type="text" placeholder="Pesquisar..." id="tags">-->
                    <div class="autocomplete">
                    <input id="myInput" type="text" name="tags" placeholder="Tags">
                    </div>
                    @forelse($tags as $tag)
                        <div class="col-sm">
                            <label class="checkbox-inline">
                                <input
                                    type="checkbox" value="{{ $tag->id }}"
                                    id="tag" name="tags[]"
                                    style="transform: scale(1.5);">
                                {{ $tag->name }}
                            </label>
                        </div>
                    @empty
                         <p><h5>Nao ha tags cadastradas</h5></p>
                    @endforelse
                </label>

                </div></li>

            </ul>
        </div>
    </div>

    <div class="field is-grouped">
        <div class="control py-2">
            <button class="btn btn-dark  float-md-right" type="submit" >
                Aplicar filtros <i class="fas fa-search px-2"></i>
            </button>

            <button class="btn btn-light border  float-md-right" type="submit"  action="{{ route('documents.index') }}">
                <a href="{{ route('documents.index') }}">
                    Limpar filtros <i class="fas fa-eraser px-2"></i>
                </a>
            </button>

            <button class="btn btn-light border float-md-left px-2" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                +
            </button>

            <div class="row px-4">
                <div class="collapse dropdown-menu-lg-right float-md-left" id="collapseExample" >
                    <div class="control" id="is_active">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="is_active" value="1">
                            <label class="form-check-label" for="inlineRadio1">Esta vigente</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="is_active" value="-1">
                            <label class="form-check-label" for="inlineRadio2">Nao esta vigente</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>


</div>
<br>
<br>
@if (request()->input('word') || request()->input('categories') || request()->input('first_date') || request()->input('last_date') || request()->input('tags') || request()->input('is_active'))
    <div class="border p-2">
        <b>Filtro aplicado:</b>
    @if (request()->input('word'))
        <br>Nome Documento / Descricao:
        <b class="px-2"> {{ request()->input('word') }} </b>
    @endif

    @if (request()->input('categories'))
        <br>Categorias:
        @foreach ( request()->input('categories')  as $cat)
            <b class="p-1">{{ $category = $categories->where('id', $cat)->first()->name }}</b>,
        @endforeach
    @endif

    @if (request()->input('first_date') || request()->input('last_date'))
        <?php
        $first_date = date('d/m/Y', strtotime(request()->input('first_date')));
        $last_date = date('d/m/Y', strtotime(request()->input('last_date')));
        ?>

        @if (request()->input('first_date') && request()->input('last_date'))
            <br>Data de publicacao:
            <b class="px-2">de {{ $first_date }}
            ate {{ $last_date }} </b>
        @elseif (request()->input('first_date'))
             <br>Documentos publicados:
             <b class="px-2">a partir de
             {{ $first_date }}</b>
             ate a data de hoje.
        @elseif (request()->input('last_date'))
              <br>Documentos publicados:
              <b class="px-2">ate {{ $last_date }}</b>
        @endif
    @endif

    @if (request()->input('tags'))
        <br>Tags:
        @foreach ( request()->input('tags')  as $tag)
            <b class="p-1">{{ $tag = $tags->where('id', $tag)->first()->name }} </b>
        @endforeach
    @endif

    @if (request()->input('is_active'))
        <br>Vigencia:
        <b class="p-1">{{ request()->input('is_active') == "1" ? "Vigente" : "Revogado" }}</b>
    @endif

    </div>
@endif



    <?php $all_tags = [];
    foreach($tags as $tag)
        array_push($all_tags, $tag->name);
    ?>
<script>
    function autocomplete(inp, arr) {
        /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
        var currentFocus;
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value;
            /*close any already open lists of autocompleted values*/
            closeAllLists();
            if (!val) { return false;}
            currentFocus = -1;
            /*create a DIV element that will contain the items (values):*/
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            /*append the DIV element as a child of the autocomplete container:*/
            this.parentNode.appendChild(a);
            /*for each item in the array...*/
            for (i = 0; i < arr.length; i++) {
                /*check if the item starts with the same letters as the text field value:*/
                if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    /*create a DIV element for each matching element:*/
                    b = document.createElement("DIV");
                    /*make the matching letters bold:*/
                    b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                    b.innerHTML += arr[i].substr(val.length);
                    /*insert a input field that will hold the current array item's value:*/
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                    /*execute a function when someone clicks on the item value (DIV element):*/
                    b.addEventListener("click", function(e) {
                        /*insert the value for the autocomplete text field:*/
                        inp.value = this.getElementsByTagName("input")[0].value;
                        /*close the list of autocompleted values,
                        (or any other open lists of autocompleted values:*/
                        closeAllLists();
                    });
                    a.appendChild(b);
                }
            }
        });
        /*execute a function presses a key on the keyboard:*/
        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                /*If the arrow DOWN key is pressed,
                increase the currentFocus variable:*/
                currentFocus++;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 38) { //up
                /*If the arrow UP key is pressed,
                decrease the currentFocus variable:*/
                currentFocus--;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 13) {
                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                e.preventDefault();
                if (currentFocus > -1) {
                    /*and simulate a click on the "active" item:*/
                    if (x) x[currentFocus].click();
                }
            }
        });
        function addActive(x) {
            /*a function to classify an item as "active":*/
            if (!x) return false;
            /*start by removing the "active" class on all items:*/
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            /*add class "autocomplete-active":*/
            x[currentFocus].classList.add("autocomplete-active");
        }
        function removeActive(x) {
            /*a function to remove the "active" class from all autocomplete items:*/
            for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
            }
        }
        function closeAllLists(elmnt) {
            /*close all autocomplete lists in the document,
            except the one passed as an argument:*/
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }
        /*execute a function when someone clicks in the document:*/
        document.addEventListener("click", function (e) {
            closeAllLists(e.target);
        });
    }

    //var tags = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];

    var tags = [];
    tags = <?php echo json_encode($all_tags); ?>

    console.log(tags);


    //var tags = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];
    autocomplete(document.getElementById("myInput"), tags);

</script>
