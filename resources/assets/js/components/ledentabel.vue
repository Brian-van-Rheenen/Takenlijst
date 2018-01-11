<template>
    <div class="leden-container">
        <table>
            <tr>
                <th v-for="header in headers" v-text="header.beschrijving"></th>
            </tr>

            <tr v-for="persoon in personeel">
                <td v-text="persoon.naam"></td>
                <td class="rechts"><i class="material-icons verwijder" v-on:click="verwijder(persoon)">delete</i></td>
            </tr>
        </table>

        <div class="input">
            <div class="input-group">
                <input type="text" class="naam" name="naam" v-model="naam" placeholder="Naam">
            </div>

            <button class="toevoegen" v-on:click="toevoegen">Toevoegen</button>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'ledentabel',
        props: ['werknemers'],
        data() {
            return {
                headers: [
                    { beschrijving: "Naam" },
                    { beschrijving: "Acties" }
                ],
                personeel: this.werknemers,
                naam: null
            }
        },
        methods: {
            toevoegen() {
                axios.post('/toevoegen', {
                    naam: this.naam
                }).then((res) => {
                    this.personeel.push(res.data);
                    this.naam = null;
                });
            },
            verwijder(persoon) {
                axios.post(`/verwijder/${persoon.id}`, {
                    id: persoon.id
                }).then((res) => {
                    var index = this.personeel.findIndex(x => x.id==persoon.id);
                    this.personeel.splice(index, 1);
                });
            }
        }
    }
</script>