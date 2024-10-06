import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import React, { useState } from "react";

export default function Dashboard({quote} : {quote:any}) {
    const [rating, setRating] = useState(null);
    const [hover, setHover] = useState(null);
    const [totalStars, setTotalStars] = useState(5);
  
    const handleChange = (e) => {
      setTotalStars(parseInt(Boolean(e.target.value, 10) ? e.target.value : 5));
    };

    const randomNumberInRange = (min:number, max:number) => {
        return Math.floor(Math.random()
            * (max - min + 1)) + min;
    };

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Your Inspirational Quote
                </h2>
            }
        >
            <Head title="Home" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <blockquote className={`q-card q-card-color-${randomNumberInRange(1,3)}`}>
                                <div className="content">{quote.quote}</div>
                                <div className='author'>{quote.author}</div>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            {[...Array(totalStars)].map((star, index) => {
                                const currentRating = index + 1;

                                return (
                                <label key={index}>
                                    <input
                                    key={star}
                                    type="radio"
                                    name="rating"
                                    value={currentRating}
                                    onChange={() => setRating(currentRating)}
                                    />
                                    <span
                                    className="star"
                                    style={{
                                        color:
                                        currentRating <= (hover || rating) ? "#ffc107" : "#e4e5e9",
                                    }}
                                    onMouseEnter={() => setHover(currentRating)}
                                    onMouseLeave={() => setHover(null)}
                                    >
                                    &#9733;
                                    </span>
                                </label>
                                );
                            })}
                            <br />
                            <br />
                            <p>Your rating is: {rating}</p>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
