import RatingBreakdownRow from '@/Components/RatingBreakdownRow';

export default function RatingBreakdown({ratings} : {ratings:any}) {
    return (
        <div>
            <h2 className="text-lg font-medium text-gray-900">
                Rating breakdown
            </h2>
            <div className="mt-6">
                <RatingBreakdownRow rating={5} ratingVotes={ratings.rating_5} totalVotes={ratings.total}/>
                <RatingBreakdownRow rating={4} ratingVotes={ratings.rating_4} totalVotes={ratings.total}/>
                <RatingBreakdownRow rating={3} ratingVotes={ratings.rating_3} totalVotes={ratings.total}/>
                <RatingBreakdownRow rating={2} ratingVotes={ratings.rating_2} totalVotes={ratings.total}/>
                <RatingBreakdownRow rating={1} ratingVotes={ratings.rating_1} totalVotes={ratings.total}/>
            </div>
            <div className="mt-6">
                Total number of votes: <strong>{ratings.total}</strong>
            </div>
        </div>
    );
}