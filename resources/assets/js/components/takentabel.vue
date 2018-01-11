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
                        <input type="text" class="select-dropdown" value="" v-bind:name="[dag.dag,taak.beschrijving]" readonly>
                        <ul class="dropdown-content">
                            <li v-on:click="keuze(dag.dag,taak.beschrijving,null)"></li>
                            <li v-for="persoon in personeel" v-on:click="keuze(dag.dag,taak.beschrijving,persoon.id)">
                                <span v-text="persoon.naam"></span>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        </table>

        <div class="knoppen">
            <button class="print" v-on:click="printen">Print</button>
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
                personeel: this.werknemers
            }
        },
        mounted() {
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
                                    var index = this.personeel.findIndex(x => x.id==this.databasetaken[i].werknemer_id);
                                    if (index != -1)
                                    {
                                        this.dagen[j].taken[k].werknemer = this.databasetaken[i].werknemer_id;

                                        var dag = this.databasetaken[i].dag;
                                        var taak = this.databasetaken[i].taak;
                                        var naam = this.personeel[index].naam;

                                        $(".select-dropdown").each(function() {
                                            if (this.name == dag + ',' + taak)
                                            {
                                                $(this).val(naam);
                                            }
                                        });
                                    }
                                }
                            }
                        }
                    }
                }
            }
        },
        methods: {
            printen() {
                $('.taken').printThis();
            },
            opslaan() {
                axios.post('/opslaan', {
                    taken: this.dagen
                }).then((res) => {
                    $('.melding').animate({'opacity': 0}, 100, function () {
                        $(this).text('Het opslaan is gelukt.');
                        $(this).removeClass('mislukt').addClass('gelukt');
                    }).animate({'opacity': 1}, 500).delay(5000).animate({'opacity': 0}, 500);
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
                $(event.target).parentsUntil('td').find('.select-dropdown').val(event.target.innerHTML);

                for (var i = 0; i < this.dagen.length; ++i)
                {
                    if (this.dagen[i].dag == dag)
                    {
                        for (var j = 0; j < this.dagen[i].taken.length; ++j)
                        {
                            if (this.dagen[i].taken[j].beschrijving == taak)
                            {
                                this.dagen[i].taken[j].werknemer = werknemer_id;
                            }
                        }
                    }
                }
            }
        }
    }
</script>