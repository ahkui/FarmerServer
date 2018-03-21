<template>
    <div id="filter-box">
        <div class="rounded">
            <div style="padding:0.5rem">
                <Multiselect 
                v-model="value" 
                :options="options" 
                :loading="isLoading"
                :multiple="true" 
                :searchable="true" 
                :internal-search="false" 
                :hide-selected="true" 
                :close-on-select="false" 
                :clear-on-select="true" 
                :show-no-results="false" 
                :max-height="600" 
                @search-change="asyncFind" 
                placeholder="Pick some" />
            </div>
        </div>
    </div>
</template>
<script>
import Multiselect from 'vue-multiselect'
export default {
    components: { Multiselect },
    data() {
        return {
            value: [],
            options: [],
            isLoading: true,
        }
    },
    created: function() {
        console.log("compoment created")
        axios.post('api/filter/tags').then(response => {
            this.options = response.data
            this.isLoading = false
        })
    },
    methods: {
        asyncFind(query) {
            console.log("find " + query)
            this.isLoading = true
            axios.post('api/filter/tags',{tag:query}).then(response => {
                this.options = response.data
                this.isLoading = false
            })
        }
    }
}
</script>