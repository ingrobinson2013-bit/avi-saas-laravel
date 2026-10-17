import '../css/app.css';
import React from 'react';
import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'AviPetApp';

createInertiaApp({
    title: (title) => title ? `${title}` : appName,
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.tsx', { eager: true });
        const page = pages[`./Pages/${name}.tsx`] as any;
        if (!page) {
            throw new Error(`Inertia page not found: ./Pages/${name}.tsx`);
        }
        return page.default;
    },
    setup({ el, App, props }) {
        const root = createRoot(el);
        root.render(<App {...props} />);
    },
    progress: {
        color: '#6D28D9',
    },
});
