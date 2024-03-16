import memoryPlantation from './memory-plantation'
import dashboard from './dashboard'
import type { VerticalNavItems } from '@layouts/types'

export default [...dashboard, ...memoryPlantation] as VerticalNavItems
