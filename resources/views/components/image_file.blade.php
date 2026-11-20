<label class="input_groupe">
    <p class="titre">{{ $nameGrpFile }} :</p>
    <p class="description">Soit un svg de moins de 70ko, soit une image de plus de 512px par côté.</p>


    <div class="@if(isset($displayMode)) 
            @if($displayMode==2)
                photo_carre
            @elseif ($displayMode==1)
                photo_rect 
            @else
                photo_rond
            @endif
        @else photo_rond @endif">
        <img id="photo_profil_img_{{$alea}}" src="{{ $urlImg }}"
            alt="Emplacement image" />
    </div>
    <label>
        <input type="file" name="image_{{$alea}}" class="input" id="original_input_file_{{$alea}}" accept="image/*" onchange="affichage_photo_dynamique_{{$alea}}(event)">
    </label>
    <span class="filename" id="filename_{{$alea}}">Sélectionnez un fichier</span>
    <button type="button" id="remove_file_{{$alea}}" onclick="supprimer_photo_{{$alea}}()" style="display:none;">
        ✕
    </button>
</label>



<script>
    var photo_profil_{{$alea}};
    var bouton_modifier_{{$alea}};
    var filename_{{$alea}};


    function init_{{$alea}}() {
        /*affichage dynamique*/
        photo_profil_{{$alea}} = document.getElementById('photo_profil_img_{{$alea}}');
        bouton_modifier_{{$alea}} = document.getElementById('original_input_file_{{$alea}}');
        filename_{{$alea}} = document.getElementById('filename_{{$alea}}');
        /*accessibilité*/
        bouton_modifier_{{$alea}}.addEventListener("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode === 13) {
                bouton_modifier_{{$alea}}.click();
            }
        });
    };

    window.addEventListener("load",init_{{$alea}});

    function affichage_photo_dynamique_{{$alea}}(event) {
        if (!event.target.files || !event.target.files[0]) {
            return;
        }

        if (event.target.files[0].size > 1024000000) {
            alert("Cette image est trop volumineuse.");
            event.target.value = "";
            return;
        }

        photo_profil_{{$alea}}.src = URL.createObjectURL(event.target.files[0]);

        photo_profil_{{$alea}}.onload = function() {
            URL.revokeObjectURL(photo_profil_{{$alea}}.src);
            filename_{{$alea}}.innerHTML = event.target.files[0].name;

            document.getElementById('remove_file_{{$alea}}').style.display = "inline-block";
        };
    }

    function supprimer_photo_{{$alea}}() {
        // Réinitialiser l'input file
        bouton_modifier_{{$alea}}.value = "";

        // Réinitialiser le nom du fichier
        filename_{{$alea}}.innerHTML = "Sélectionnez un fichier";

        // Masquer le bouton de suppression
        document.getElementById('remove_file_{{$alea}}').style.display = "none";

        photo_profil_{{$alea}}.src = "";
    }
</script>