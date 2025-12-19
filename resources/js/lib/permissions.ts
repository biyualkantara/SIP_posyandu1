const SUPER_ADMIN = 'Super Admin';
const ADMIN = 'Admin';
const KADER = 'Kader';

export function canViewBerita(level: string): boolean {
    return [ADMIN, SUPER_ADMIN, KADER].includes(level);
}

export function canViewOperator(level: string): boolean {
    return [SUPER_ADMIN].includes(level);
}

