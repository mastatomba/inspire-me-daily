import { SVGAttributes } from 'react';

export default function ApplicationLogo(props: SVGAttributes<SVGElement>) {
    return (
        <img
            id="logo"
            width={30}
            height={30}
            src="quotes.png"
        />
    );
}
