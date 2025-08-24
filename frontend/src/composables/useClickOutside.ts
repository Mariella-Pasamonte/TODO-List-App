import { onMounted, onBeforeUnmount } from "vue"
import type { Ref } from "vue"

export function useClickOutside(elRef: Ref<HTMLElement | null>, boolVar: Ref<boolean>) {
  function handleClickOutside(event: MouseEvent) {
    if (elRef.value && !elRef.value.contains(event.target as Node)) {
      boolVar.value = false
    }
  }

  onMounted(() => {
    document.addEventListener("mousedown", handleClickOutside)
  })

  onBeforeUnmount(() => {
    document.removeEventListener("mousedown", handleClickOutside)
  })
}