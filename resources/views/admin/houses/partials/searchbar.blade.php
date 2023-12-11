<script>
  // Inserisco le opzioni del construttore di SearchBox
    var options = {
      // Opzioni di ricerca
        searchOptions: {
          key: "5uNY3BSE9gSMXl2atJSMJJrZAbfvhazZ",
          language: "it-IT",
          limit: 5,
        },
        // Autocomplete
        autocompleteOptions: {
          key: "5uNY3BSE9gSMXl2atJSMJJrZAbfvhazZ",
          language: "it-IT",
        },
        // placeholder
        placeholder: "Es. Via Roma...",
      }
      // Elemento SearchBox
      var ttSearchBox = new tt.plugins.SearchBox(tt.services, options)
      // SearchBox in HTML
      var searchBoxHTML = ttSearchBox.getSearchBoxHTML()
      

      // Prendo un elemento 
      let addressElement = document.getElementById('address-element')
      // inserisco il searchBox HTML dentro l'elemento selezionato
      addressElement.append(searchBoxHTML)

      // boolean form
      let booleanInput = false;

      // Prendo l'input della searchBox
      const addressInput = document.getElementsByTagName('input')[4];
        
        // Istanzo gli attributi sul input address
        addressInput.setAttribute('id', 'address');
        addressInput.setAttribute('name', 'address');
        addressInput.setAttribute('value', '{{ old('address', $house->address) }}');
        addressInput.setAttribute('autocomplete', 'off');
        addressInput.setAttribute('class',
        'tt-search-box-input @error('address') is-invalid @enderror'
        );

        // Istanzo il valore precedente dell'input address
        let previousState = addressInput.value

        // Al click dell'input
        addressInput.addEventListener('focus', (e) => {
          // Se il valore precedente inizia con il valore dell'input rimane quello precedente
          if (!addressInput.value.startsWith(previousState) ) {
            addressInput.value = previousState; // revert change
          }
          // Resetto il valore per l'invio del form (per obbligare a selezionare un valore nei risultati del dropdown)
          if (booleanInput) {
            booleanInput = !booleanInput
          }
          console.log(addressInput.value);
        })

        // Al click fuori del input
        addressInput.addEventListener('focusout', function(data){
          
          console.log(addressInput.value);
          if (!addressInput.value.startsWith(previousState) ) {
            addressInput.value = previousState; // revert change
            booleanInput = false;
          }
          // Se il valore per inviare il form è negativo resetto tutti i valori dell'input
          // if (!booleanInput) {
          //     addressInput.value = null  
          //     previousState = null;
          //   }          
          }
        )

      // Chiamo l'evento tomtom.searchbox.resultselected
      ttSearchBox.on("tomtom.searchbox.resultselected", function (data) {
        // Inserisco il valore dell'indirizzo dall'oggetto data in una variabile
        let addressVal = data.data.result.address.freeformAddress

        // Inserisco il valore dell'indirizzo dentro il valore dell'input nascosto 
        addressInput.value = addressVal;

        // Aggiorno il valore precedente
        previousState = addressInput.value;

        // Il form puo essere mandato
        booleanInput = true;
        console.log(addressInput.value);
      })

</script>