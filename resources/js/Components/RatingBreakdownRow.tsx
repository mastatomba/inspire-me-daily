import ProgressBar from "@ramonak/react-progress-bar";

export default function RatingBreakdownRow({rating, ratingVotes, totalVotes} : {rating:number, ratingVotes:number, totalVotes:number}) {
    return (
        <div className="flex flex-row gap-4">
            <div className="flex-none w-8">
                {rating}
            </div>
            <div className="flex-1">
                <ProgressBar completed={Math.round((ratingVotes / totalVotes) * 100)} bgColor="#f5c518"/>
            </div>
            <div className="flex-none w-24">
                {ratingVotes} votes
            </div>
        </div>
    );
}