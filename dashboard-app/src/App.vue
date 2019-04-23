<template>
    <v-app v-if="loaded">

        <v-content>
            <v-data-table
                    :headers="headers"
                    :items="bids"
                    :loading="!loaded"
                    :pagination.sync="pagination"
                    class="elevation-1"

            >
                <template v-slot:items="props">
                    <td >{{ auctions[props.item.auction_id].post_title }}</td>
                    <td >{{ props.item.bid }}</td>
                    <td >{{ props.item.name }}</td>
                </template>
            </v-data-table>
        </v-content>
    </v-app>
</template>

<script>
    import HelloWorld from './components/HelloWorld'

    export default {
        name: 'App',
        // components: {
        //   HelloWorld
        // },
        mounted(){
            // `this` points to the vm instance
            console.log(uad_dashboard);
            //console.log(this);
            this.bids = uad_dashboard.bids;
            this.auctions = uad_dashboard.auctions;
            this.loaded = true;
        },
        data(){
            return {
                pagination: {
                    sortBy: 'bid',
                    descending: true,
                    rowsPerPage : -1,
                },
                headers: [
                    {text: 'Auction', value: 'auction_id'},
                    {text: 'High bid', value: 'bid'},
                    {text: 'Bidder', value: 'name'}
                ],
                bids: [],
                auctions : [],
                uad_dashboard : [],
                loaded : false
            }
        }

    }
</script>
