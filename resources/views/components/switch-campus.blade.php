{{-- À dynamiser plus tard en tant que component réutilisable ... --}}
@php
    use App\Models\Site;
@endphp

<div class="switch-campus" style="width:200px;">
    <select value="">
        <option value="0">Aucun</option>
        @foreach (Site::all() as $site)
            <option value="{{ $site->id }}" @selected($campus->id == $site->id)>{{ $site->label }}</option>
        @endforeach
    </select>
</div>

<script>
    var x, i, j, l, ll, selElmnt, a, b, c;
    const campus = [
        "0",
        @foreach (Site::all() as $site)
            '{{ $site->id }}',
        @endforeach
    ];
    /* Look for any elements with the class "custom-select": */
    x = document.getElementsByClassName("switch-campus");
    l = x.length;
    for (i = 0; i < l; i++) {
        selElmnt = x[i].getElementsByTagName("select")[0];
        ll = selElmnt.length;
        /* For each element, create a new DIV that will act as the selected item: */
        a = document.createElement("DIV");
        a.setAttribute("class", "select-selected");
        a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        x[i].appendChild(a);
        /* For each element, create a new DIV that will contain the option list: */
        b = document.createElement("DIV");
        b.setAttribute("class", "select-items select-hide");
        for (j = 1; j < ll; j++) {
            /* For each option in the original select element,
            create a new DIV that will act as an option item: */
            c = document.createElement("DIV");
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.addEventListener("click", function(e) {
                /* When an item is clicked, update the original select box,
                and the selected item: */
                var y, s, h, i;
                s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                h = this.parentNode.previousSibling;

                for (i = 0; i < s.length; i++) {
                    if (s.options[i].innerHTML == this.innerHTML) {
                        s.selectedIndex = i;
                        h.innerHTML = this.innerHTML;
                        y = this.parentNode.getElementsByClassName("same-as-selected");

                        for (var k = 0; k < y.length; k++) {
                            y[k].removeAttribute("class");
                        }
                        this.setAttribute("class", "same-as-selected");
                        break;
                    }
                }
                h.click();
                
                // Get link to selected page
                var targetCampus = campus[i]
                var currentLinkWithoutCampus = window.location.pathname
                
                for(var j=0; j<campus.length; j++){
                    la_fin='/'+campus[j]
                    if(currentLinkWithoutCampus.endsWith(la_fin)){
                        currentLinkWithoutCampus = currentLinkWithoutCampus.substring(0, currentLinkWithoutCampus.length - la_fin.length)
                    }
                }
                
                // Open selected page
                location.replace(pathJoin([currentLinkWithoutCampus, targetCampus]))
            });
            b.appendChild(c);
        }
        x[i].appendChild(b);
        a.addEventListener("click", function(e) {
            /* When the select box is clicked, close any other select boxes,
            and open/close the current select box: */
            e.stopPropagation();
            closeAllSelect(this);
            this.nextSibling.classList.toggle("select-hide");
            this.classList.toggle("select-arrow-active");
        });
    }

    function closeAllSelect(elmnt) {
        /* A function that will close all select boxes in the document,
        except the current select box: */
        var x, y, i, xl, yl, arrNo = [];
        x = document.getElementsByClassName("select-items");
        y = document.getElementsByClassName("select-selected");
        xl = x.length;
        yl = y.length;
        for (i = 0; i < yl; i++) {
            if (elmnt == y[i]) {
                arrNo.push(i)
            } else {
                y[i].classList.remove("select-arrow-active");
            }
        }
        for (i = 0; i < xl; i++) {
            if (arrNo.indexOf(i)) {
                x[i].classList.add("select-hide");
            }
        }
    }

    function pathJoin(parts){
        var separator = '/';
        var replace   = new RegExp(separator+'{1,}', 'g');
        return parts.join(separator).replace(replace, separator);
    }

    /* If the user clicks anywhere outside the select box,
    then close all select boxes: */
    document.addEventListener("click", closeAllSelect);
</script>
