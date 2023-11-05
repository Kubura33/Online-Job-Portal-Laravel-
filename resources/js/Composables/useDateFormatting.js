import {computed} from 'vue'
import moment from 'moment'

export const useDateFormatting = (date) => {

if (date) {
return moment(String(date)).format('YYYY-MM-DD')
}
}
