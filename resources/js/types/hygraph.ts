export type NavigationItem = {
    id: string;
    label: string;
    url: string;
    order: number;
};

export type RichContent = {
    html: string;
};

export type Author = {
    name: string;
    bio?: string | null;
    picture?: {
        url: string;
    } | null;
};

export type Page = {
    title: string;
    slug: string;
    content: RichContent;
};

export type Post = {
    title: string;
    slug: string;
    excerpt: string;
    content?: RichContent;
    createdAt: string;
    author?: Author | null;
};
