<template>
  <div class="corporate-matching">
    <header>
      <h2 class="text-lg font-semibold">
        Corporate Matching for Roosevelt Franklin Elementary Fun Run
      </h2>
    </header>

    <div>
      <BTable
        ref="table"
        class="mt-4"
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

          <BTableColumn field="status" label="Status" sortable>
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
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Proin ornare magna eros, eu pellentesque tortor vestibulum
                    ut.
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
    </div>
  </div>
</template>

<script>
const companies = require('@/static/data/companies.json')

export default {
  name: 'CorporateMatching',
  data() {
    return {
      // Valid DTD Statuses
      // :match-complete, :waiting-for-verification, :ineligible, :waiting-for-donor-action, :pending-payment, :unknown-employer
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
      companies,
      // columns: [
      //   {
      //     field: 'id',
      //     label: 'ID',
      //     width: '40',
      //     numeric: true,
      //   },
      //   {
      //     field: 'company_name',
      //     label: 'Company',
      //     searchable: true,
      //   },
      //   {
      //     field: 'amount',
      //     label: 'Amount',
      //   },
      //   {
      //     field: 'status',
      //     label: 'Status',
      //   },
      //   {
      //     field: 'submitted_at',
      //     label: 'Date Submitted',
      //     centered: true,
      //   },
      // ],
    }
  },
  methods: {
    toggle(row) {
      this.$refs.table.toggleDetails(row)
    },
  },
}
</script>
