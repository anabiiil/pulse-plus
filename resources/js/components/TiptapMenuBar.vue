<template>
    <div class="tiptap-menu-bar" v-if="editor">
        <button
            @click="editor.chain().focus().toggleBold().run()"
            :class="{ 'is-active': editor.isActive('bold') }"
            type="button"
        >
            <i class="las la-bold"></i>
        </button>
        <button
            @click="editor.chain().focus().toggleItalic().run()"
            :class="{ 'is-active': editor.isActive('italic') }"
            type="button"
        >
            <i class="las la-italic"></i>
        </button>
        <button
            @click="editor.chain().focus().toggleStrike().run()"
            :class="{ 'is-active': editor.isActive('strike') }"
            type="button"
        >
            <i class="las la-strikethrough"></i>
        </button>
        <span class="divider"></span>
        <button
            @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
            :class="{ 'is-active': editor.isActive('heading', { level: 1 }) }"
            type="button"
        >
            H1
        </button>
        <button
            @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
            :class="{ 'is-active': editor.isActive('heading', { level: 2 }) }"
            type="button"
        >
            H2
        </button>
        <button
            @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
            :class="{ 'is-active': editor.isActive('heading', { level: 3 }) }"
            type="button"
        >
            H3
        </button>
        <span class="divider"></span>
        <button
            @click="editor.chain().focus().toggleBulletList().run()"
            :class="{ 'is-active': editor.isActive('bulletList') }"
            type="button"
        >
            <i class="las la-list-ul"></i>
        </button>
        <button
            @click="editor.chain().focus().toggleOrderedList().run()"
            :class="{ 'is-active': editor.isActive('orderedList') }"
            type="button"
        >
            <i class="las la-list-ol"></i>
        </button>
        <span class="divider"></span>
        <button
            @click="editor.chain().focus().toggleCodeBlock().run()"
            :class="{ 'is-active': editor.isActive('codeBlock') }"
            type="button"
        >
            <i class="las la-code"></i>
        </button>
        <button
            @click="editor.chain().focus().toggleBlockquote().run()"
            :class="{ 'is-active': editor.isActive('blockquote') }"
            type="button"
        >
            <i class="las la-quote-right"></i>
        </button>
        <span class="divider"></span>
        <button
            @click="editor.chain().focus().setHorizontalRule().run()"
            type="button"
        >
            <i class="las la-minus"></i>
        </button>
        <span class="divider"></span>
        <button
            @click="editor.chain().focus().undo().run()"
            :disabled="!editor.can().undo()"
            type="button"
        >
            <i class="las la-undo"></i>
        </button>
        <button
            @click="editor.chain().focus().redo().run()"
            :disabled="!editor.can().redo()"
            type="button"
        >
            <i class="las la-redo"></i>
        </button>
    </div>
</template>

<script setup lang="ts">
import { Editor } from '@tiptap/vue-3';

defineProps<{
    editor: Editor | null;
}>();
</script>

<style scoped>
.tiptap-menu-bar {
    display: flex;
    flex-wrap: wrap;
    gap: 0.25rem;
    padding: 0.5rem;
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    border-radius: 0.25rem 0.25rem 0 0;
}

.tiptap-menu-bar button {
    background-color: white;
    border: 1px solid #dee2e6;
    border-radius: 0.25rem;
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: #495057;
    cursor: pointer;
    transition: all 0.2s;
    min-width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.tiptap-menu-bar button:hover:not(:disabled) {
    background-color: #e9ecef;
    border-color: #adb5bd;
}

.tiptap-menu-bar button.is-active {
    background-color: #0d6efd;
    color: white;
    border-color: #0d6efd;
}

.tiptap-menu-bar button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.tiptap-menu-bar .divider {
    width: 1px;
    background-color: #dee2e6;
    margin: 0 0.25rem;
}

.tiptap-menu-bar i {
    font-size: 1.125rem;
}
</style>
