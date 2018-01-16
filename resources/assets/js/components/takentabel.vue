<template>
    <div class="lijst-container">
        <table class="taken">
            <tr>
                <th></th>
                <th v-for="taak in taken" v-text="taak.beschrijving"></th>
            </tr>

            <tr v-for="dag in dagen">
                <td v-text="dag.dag"></td>
                <td v-for="taak in taken">
                    <div class="select-wrapper">
                        <span class="caret no-print">▼</span>
                        <textarea type="text" class="select-dropdown" value="" v-bind:name="[dag.dag,taak.beschrijving]" readonly></textarea>
                        <ul class="dropdown-content">
                            <li v-for="persoon in personeel" v-on:click="keuze(dag.dag,taak.beschrijving,persoon.id)">
                                <span v-text="persoon.naam"></span>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        </table>

        <div class="knoppen">
            <div class="knoppen-links">
                <button class="print" v-on:click="printen">Print</button>
                <button class="reset" v-on:click="reset">Resetten</button>
            </div>
            <span class="melding"></span>
            <button class="opslaan" v-on:click="opslaan">Opslaan</button>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'takentabel',
        props: ['databasetaken', 'werknemers'],
        data() {
            return {
                taken: [
                    { beschrijving: "Vaatwasser uitruimen" },
                    { beschrijving: "Tafeldekken" },
                    { beschrijving: "Afruimen" },
                    { beschrijving: "WC schoonmaken" },
                    { beschrijving: "Vegen/dweilen of stofzuigen" },
                    { beschrijving: "Bureau schoonmaken" },
                    { beschrijving: "Koelkast schoonmaken" },
                    { beschrijving: "Kastjesdeuren en aanrecht schoonmaken" }
                ],
                dagen: [
                    { dag: "Maandag", taken: [
                        { beschrijving: "Vaatwasser uitruimen", werknemer: null },
                        { beschrijving: "Tafeldekken", werknemer: null },
                        { beschrijving: "Afruimen", werknemer: null },
                        { beschrijving: "WC schoonmaken", werknemer: null },
                        { beschrijving: "Vegen/dweilen of stofzuigen", werknemer: null },
                        { beschrijving: "Bureau schoonmaken", werknemer: null },
                        { beschrijving: "Koelkast schoonmaken", werknemer: null },
                        { beschrijving: "Kastjesdeuren en aanrecht schoonmaken", werknemer: null }
                    ] },
                    { dag: "Dinsdag", taken: [
                        { beschrijving: "Vaatwasser uitruimen", werknemer: null },
                        { beschrijving: "Tafeldekken", werknemer: null },
                        { beschrijving: "Afruimen", werknemer: null },
                        { beschrijving: "WC schoonmaken", werknemer: null },
                        { beschrijving: "Vegen/dweilen of stofzuigen", werknemer: null },
                        { beschrijving: "Bureau schoonmaken", werknemer: null },
                        { beschrijving: "Koelkast schoonmaken", werknemer: null },
                        { beschrijving: "Kastjesdeuren en aanrecht schoonmaken", werknemer: null }
                    ] },
                    { dag: "Woensdag", taken: [
                        { beschrijving: "Vaatwasser uitruimen", werknemer: null },
                        { beschrijving: "Tafeldekken", werknemer: null },
                        { beschrijving: "Afruimen", werknemer: null },
                        { beschrijving: "WC schoonmaken", werknemer: null },
                        { beschrijving: "Vegen/dweilen of stofzuigen", werknemer: null },
                        { beschrijving: "Bureau schoonmaken", werknemer: null },
                        { beschrijving: "Koelkast schoonmaken", werknemer: null },
                        { beschrijving: "Kastjesdeuren en aanrecht schoonmaken", werknemer: null }
                    ] },
                    { dag: "Donderdag", taken: [
                        { beschrijving: "Vaatwasser uitruimen", werknemer: null },
                        { beschrijving: "Tafeldekken", werknemer: null },
                        { beschrijving: "Afruimen", werknemer: null },
                        { beschrijving: "WC schoonmaken", werknemer: null },
                        { beschrijving: "Vegen/dweilen of stofzuigen", werknemer: null },
                        { beschrijving: "Bureau schoonmaken", werknemer: null },
                        { beschrijving: "Koelkast schoonmaken", werknemer: null },
                        { beschrijving: "Kastjesdeuren en aanrecht schoonmaken", werknemer: null }
                    ] },
                    { dag: "Vrijdag", taken: [
                        { beschrijving: "Vaatwasser uitruimen", werknemer: null },
                        { beschrijving: "Tafeldekken", werknemer: null },
                        { beschrijving: "Afruimen", werknemer: null },
                        { beschrijving: "WC schoonmaken", werknemer: null },
                        { beschrijving: "Vegen/dweilen of stofzuigen", werknemer: null },
                        { beschrijving: "Bureau schoonmaken", werknemer: null },
                        { beschrijving: "Koelkast schoonmaken", werknemer: null },
                        { beschrijving: "Kastjesdeuren en aanrecht schoonmaken", werknemer: null }
                    ] }
                ],
                personeel: this.werknemers,
                unsavedchanges: false
            }
        },
        mounted() {
            window.onbeforeunload = this.unloadPage;

            if (this.databasetaken.length > 0)
            {
                for (var i = 0; i < this.databasetaken.length; ++i)
                {
                    for (var j = 0; j < this.dagen.length; ++j)
                    {
                        if (this.databasetaken[i].dag == this.dagen[j].dag)
                        {
                            for (var k = 0; k < this.dagen[j].taken.length; ++k)
                            {
                                if (this.databasetaken[i].taak == this.dagen[j].taken[k].beschrijving)
                                {
                                    if (this.databasetaken[i].werknemer_id != null)
                                    {
                                        var werknemer_ids = this.databasetaken[i].werknemer_id.split(', ');

                                        for (var l = 0; l < werknemer_ids.length; l++)
                                        {
                                            var index = this.personeel.findIndex(x => x.id==werknemer_ids[l]);
                                            if (index != -1)
                                            {
                                                if (this.dagen[j].taken[k].werknemer != null)
                                                {
                                                    this.dagen[j].taken[k].werknemer = this.dagen[j].taken[k].werknemer + ', ' + werknemer_ids[l];
                                                }
                                                else
                                                {
                                                    this.dagen[j].taken[k].werknemer = werknemer_ids[l];
                                                }

                                                var dag = this.databasetaken[i].dag;
                                                var taak = this.databasetaken[i].taak;
                                                var naam = this.personeel[index].naam;

                                                $(".select-dropdown").each(function() {
                                                    if (this.name == dag + ',' + taak)
                                                    {
                                                        if ($(this).val() == '')
                                                        {
                                                            $(this).val(naam);
                                                        }
                                                        else
                                                        {
                                                            $(this).val($(this).val() + ', ' + naam);
                                                        }
                                                    }
                                                });
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            this.autoresize();
        },
        methods: {
            printen() {
                $('.taken').printThis();
            },
            reset() {
                for (var i = 0; i < this.dagen.length; ++i)
                {
                    for (var j = 0; j < this.dagen[i].taken.length; ++j)
                    {
                        this.dagen[i].taken[j].werknemer = null;
                        $(".select-dropdown").each(function() {
                            $(this).val('');
                        });
                    }
                }
            },
            opslaan() {
                axios.post('/opslaan', {
                    taken: this.dagen
                }).then((res) => {
                    $('.melding').animate({'opacity': 0}, 100, function () {
                        $(this).text('Het opslaan is gelukt.');
                        $(this).removeClass('mislukt').addClass('gelukt');
                    }).animate({'opacity': 1}, 500).delay(5000).animate({'opacity': 0}, 500);
                    this.unsavedchanges = false;
                })
                .catch(function (error) {
                    $('.melding').animate({'opacity': 0}, 100, function () {
                        $(this).text('Het opslaan is niet gelukt.');
                        $(this).removeClass('gelukt').addClass('mislukt');
                    }).animate({'opacity': 1}, 500).delay(5000).animate({'opacity': 0}, 500);
                });
            },
            keuze(dag, taak, werknemer_id) {
                $(event.target).closest('.dropdown-content').css({
                    'opacity' : '0',
                    'max-height' : '0px'
                });

                var value = $(event.target).parentsUntil('td').find('.select-dropdown').val();
                var naam = event.target.innerHTML;

                if (value == '')
                {
                    $(event.target).parentsUntil('td').find('.select-dropdown').val(naam);
                }
                else
                {
                    if (value.indexOf(naam) != -1)
                    {
                        if (value.substring(0, naam.toString().length) == naam)
                        {
                            if (value.substring(0, naam.toString().length + 2) == naam + ', ')
                            {
                                $(event.target).parentsUntil('td').find('.select-dropdown').val(value.replace(naam + ', ', ''));
                            }
                            else
                            {
                                $(event.target).parentsUntil('td').find('.select-dropdown').val(value.replace(naam, ''));
                            }
                        }
                        else
                        {
                            $(event.target).parentsUntil('td').find('.select-dropdown').val(value.replace(', ' + naam, ''));
                        }
                    }
                    else
                    {
                        $(event.target).parentsUntil('td').find('.select-dropdown').val(value + ', ' + naam);
                    }
                }
                this.autoresize();
                this.unsavedchanges = true;

                for (var i = 0; i < this.dagen.length; ++i)
                {
                    if (this.dagen[i].dag == dag)
                    {
                        for (var j = 0; j < this.dagen[i].taken.length; ++j)
                        {
                            if (this.dagen[i].taken[j].beschrijving == taak)
                            {
                                if (this.dagen[i].taken[j].werknemer == null || this.dagen[i].taken[j].werknemer == '')
                                {
                                    this.dagen[i].taken[j].werknemer = werknemer_id.toString();
                                }
                                else
                                {
                                    var string = this.dagen[i].taken[j].werknemer.toString();

                                    if (string.indexOf(werknemer_id) != -1)
                                    {
                                        if (string.substring(0, werknemer_id.toString().length) == werknemer_id)
                                        {
                                            if (string.substring(0, werknemer_id.toString().length + 2) == werknemer_id + ', ')
                                            {
                                                this.dagen[i].taken[j].werknemer = this.dagen[i].taken[j].werknemer.replace(werknemer_id + ', ', '');
                                            }
                                            else
                                            {
                                                this.dagen[i].taken[j].werknemer = this.dagen[i].taken[j].werknemer.replace(werknemer_id, '');
                                            }
                                        }
                                        else
                                        {
                                            this.dagen[i].taken[j].werknemer = this.dagen[i].taken[j].werknemer.replace(', ' + werknemer_id, '');
                                        }
                                    }
                                    else
                                    {
                                        this.dagen[i].taken[j].werknemer = this.dagen[i].taken[j].werknemer + ', ' + werknemer_id;
                                    }
                                }
                            }
                        }
                    }
                }
            },
            autoresize() {
                $(function() {
                    $('textarea').each(function() {
                        $(this).css('height','auto');
                        $(this).height(this.scrollHeight);
                    });
                });
            },
            unloadPage()
            {
                var unsaved = this.unsavedchanges;
                if(unsaved)
                {
                    return "De veranderingen die je gemaakt hebt zijn nog niet opgeslagen. Weet je zeker dat je weg wilt?";
                }
            }
        }
    }
</script>