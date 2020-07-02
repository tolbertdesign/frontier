<template>
  <BTable
    ref="table"
    class="mt-4 corporate-matching-table"
    :paginated="true"
    per-page="5"
    detail-key="id"
    :detailed="true"
    :show-detail-icon="showDetailIcon"
    :mobile-cards="hasMobileCards"
    :striped="isStriped"
    :narrowed="isNarrowed"
    :bordered="isBordered"
    :hoverable="isHoverable"
    :loading="isLoading"
    :focusable="isFocusable"
    :checkable="true"
    :default-sort="['company_name', 'asc']"
    :checked-rows.sync="checkedRows"
    :checkbox-position="checkboxPosition"
    :data="isEmpty ? [] : companies"
    aria-next-label="Next page"
    aria-previous-label="Previous page"
    aria-page-label="Page"
    aria-current-label="Current page"
  >
    <template slot-scope="props">
      <BTableColumn field="company_name" label="Company Name" sortable>
        {{ props.row.company_name }}
      </BTableColumn>

      <BTableColumn field="amount" label="Amount" sortable>
        {{ props.row.amount }}
      </BTableColumn>

      <BTableColumn field="status" label="Status">
        <span
          class="inline-block w-24 px-2 py-1 text-xs tracking-wide text-center uppercase border rounded"
        >
          {{ props.row.status }}
        </span>
      </BTableColumn>

      <BTableColumn
        field="submitted_at"
        label="Date Submitted"
        sortable
        :visible="false"
      >
        {{ new Date(props.row.submitted_at).toLocaleDateString() }}
      </BTableColumn>
    </template>

    <template slot="detail" slot-scope="props">
      <div class="detail-container">
        <article class="media">
          <div class="media-content">
            <div class="content">
              <p>
                <strong>{{ props.row.status }}</strong>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
                ornare magna eros, eu pellentesque tortor vestibulum ut.
              </p>
            </div>
          </div>
        </article>
      </div>
    </template>

    <template slot="bottom-left">
      <b>Total checked</b>: {{ checkedRows.length }}
    </template>

    <template slot="empty">
      <EmptyState />
    </template>
  </BTable>
</template>

<script>
import EmptyState from '@/components/EmptyState'
const companies = require('@/__mocks__/data/corporate-matches.json')

export default {
  name: 'CorporateMatching',
  components: {
    EmptyState,
  },
  data() {
    return {
      companies,
      isEmpty: false,
      hasMobileCards: false,
      isStriped: true,
      isNarrowed: true,
      isBordered: false,
      isHoverable: false,
      isLoading: false,
      isFocusable: false,
      checkedRows: [],
      checkboxPosition: 'left',
      showDetailIcon: true,
    }
  },
  methods: {
    toggle(row) {
      this.$refs.table.toggleDetails(row)
    },
  },
}
</script>
