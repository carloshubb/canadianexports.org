<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\EventResource;
use App\Models\Event;
use App\Models\EventContact;
use App\Models\EventDetail;
use App\Models\EventMedia;
use App\Rules\ValidUrl;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EventController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $events = Event::query();

        $events = $this->whereClause($events);
        $events = $this->loadRelations($events);
        $events = $this->sortingAndLimit($events);

        return $this->apiSuccessResponse(EventResource::collection($events), 'Data Get Successfully!');
    }

    public function show(Event $event)
    {
        // Load relationships if requested
        if (isset($_GET['withMedia']) && $_GET['withMedia'] == '1') {
            $event = $event->loadMissing('media');
            $event = $event->loadMissing('eventMedia');
            $event = $event->loadMissing('eventMedia.media');
        }

        // Load event details if requested
        if (isset($_GET['withEventDetail']) && $_GET['withEventDetail'] == '1') {
            $event = $event->loadMissing('eventDetail');
        }

        // Load event contacts if requested
        if (isset($_GET['withEventContacts']) && $_GET['withEventContacts'] == '1') {
            $event = $event->loadMissing('eventContacts');
        }

        // Load the event's registration package relationship
        $event = $event->loadMissing('registrationPackage');

        // Load the customer's registration package relationship
        if ($event->customer) {
            $event->customer->loadMissing('registrationPackage');
        }

        return $this->apiSuccessResponse(new EventResource($event), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        $request['gallery_images'] = isset($request->gallery_images) && $request->gallery_images != null ? json_decode($request->gallery_images) : null;
        $validationRule = [
            'zipcode' => ['nullable'],
            'featured' => 'nullable|boolean',
            'gallery_images' => ['required', 'array'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'event_website' => ['required', new ValidUrl()],
            'exibitors_url' => ['nullable', new ValidUrl()],
            'visitors_url' => ['nullable', new ValidUrl()],
            'press_url' => ['nullable', new ValidUrl()],
            'video_url' => ['nullable', new ValidUrl()],
            'facebook_url' => ['nullable', new ValidUrl()],
            'twitter_url' => ['nullable', new ValidUrl()],
            'linkedin_url' => ['nullable', new ValidUrl()],
            'youtube_url' => ['nullable', new ValidUrl()],
            'pintrest_url' => ['nullable', new ValidUrl()],
            'instagram_url' => ['nullable', new ValidUrl()],
            'snapchat_url' => ['nullable', new ValidUrl()],
            'contacts.*.name' => 'required|string|max:255',
            'contacts.*.email' => 'required|email|max:255',
            'contacts.*.phone' => 'required|string|max:20',
            // 'contacts.*.designation' => 'required|string|max:255',
            // 'contacts.*.image_path' => 'required|string|max:255',
            'contacts.*.image_path' => 'nullable|string|max:255',
        ];
        $errorMessages = [];
        $niceNames = [
            'contacts.*.name' => 'name',
            'contacts.*.email' => 'email',
            'contacts.*.phone' => 'phone',
            // 'contacts.*.designation' => 'designation',
            'contacts.*.image_path' => 'profile image',
        ];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['title.title_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $errorMessages = array_merge($errorMessages, ['title.title_' . $language->id . '.required' => 'Title in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['country.country_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $errorMessages = array_merge($errorMessages, ['country.country_' . $language->id . '.required' => 'Country in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['city.city_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $errorMessages = array_merge($errorMessages, ['city.city_' . $language->id . '.required' => 'City in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['street_name.street_name_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['street_name.street_name_' . $language->id . '.required' => 'Street name in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['venue.venue_' . $language->id => ['nullable', 'string', 'max:255']]);
            $errorMessages = array_merge($errorMessages, ['venue.venue_' . $language->id . '.required' => 'Venue in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['product_search.product_search_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['product_search.product_search_' . $language->id . '.required' => 'Product search in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['short_description.short_description_' . $language->id => [$requiredVal, 'string', 'maxwords:30']]);
            $errorMessages = array_merge($errorMessages, ['short_description.short_description_' . $language->id . '.required' => 'Short description in ' . $language->name . ' is required.']);
            $errorMessages = array_merge($errorMessages, ['short_description.short_description_' . $language->id . '.maxwords' => 'Short description in ' . $language->name . ' must have less than 30 words.']);

            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string', 'maxwords:3000']]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'Description in ' . $language->name . ' is required.']);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.maxwords' => 'Description in ' . $language->name . ' must have less than 3000 words.']);
        }
        $this->validate($request, $validationRule, $errorMessages, $niceNames);
        if (isset($request->gallery_images)) {
            $galleryImages = $this->moveFile($request->gallery_images, 'media/events', 'events');
        }


        // $this->validate($request, $validationRule, $errorMessages, $niceNames);
        // if (!empty($request->gallery_images) && is_array($request->gallery_images) && array_filter($request->gallery_images)) {
        //     $galleryImages = $this->moveFile($request->gallery_images, 'media/events', 'events');
        // }


        $currentRouteName = \Request::route()->getName();
        $customerId = null;
        if ($currentRouteName == 'web.events.store') {
            $customerId = Auth::guard('customers')->user()->id;
        }

        foreach ($languages as $language) {
            if ($language->is_default == '1') {
                $requiredVal = 'required';
                $slug = $request['title']['title_' . $language->id] ?? null;
            }
        }

        $event = Event::create([
            'zipcode' => $request->zipcode,
            'featured' => $request->featured,
            'media_id' => isset($galleryImages, $galleryImages[0]) ? $galleryImages[0]->id : null,
            'slug' => $this->generateUniqueSlug($slug),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'event_website' => $request->event_website,
            'exibitors_url' => $request->exibitors_url,
            'visitors_url' => $request->visitors_url,
            'press_url' => $request->press_url,
            'video_url' => $request->video_url,
            'facebook_url' => $request->facebook_url,
            'twitter_url' => $request->twitter_url,
            'linkedin_url' => $request->linkedin_url,
            'youtube_url' => $request->youtube_url,
            'pintrest_url' => $request->pintrest_url,
            'instagram_url' => $request->instagram_url,
            'snapchat_url' => $request->snapchat_url,
            'customer_id' => $customerId,
        ]);

        if ($event) {
            if (isset($galleryImages)) {
                foreach ($galleryImages as $key => $file) {
                    EventMedia::create([
                        'event_id' => $event->id,
                        'media_id' => $file->id,
                    ]);
                }
            }
            foreach ($languages as $language) {
                EventDetail::create([
                    'event_id' => $event->id,
                    'language_id' => $language->id,
                    'title' => $request['title']['title_' . $language->id] ?? null,
                    'country' => $request['country']['country_' . $language->id] ?? null,
                    'city' => $request['city']['city_' . $language->id] ?? null,
                    'street_name' => $request['street_name']['street_name_' . $language->id] ?? null,
                    'venue' => $request['venue']['venue_' . $language->id] ?? null,
                    'product_search' => $request['product_search']['product_search_' . $language->id] ?? null,
                    'short_description' => $request['short_description']['short_description_' . $language->id] ?? null,
                    'description' => $request['description']['description_' . $language->id] ?? null,
                ]);
            }
            $contacts = $request->input('contacts');
            foreach ($contacts as $contactData) {
                EventContact::create([
                    'event_id' => $event->id,
                    'name' => $contactData['name'],
                    'email' => $contactData['email'],
                    'phone' => $contactData['phone'],
                    // 'designation' => $contactData['designation'],
                    'image_path' => $contactData['image_path'],
                ]);
            }
            return $this->apiSuccessResponse(new EventResource($event), 'Event has been added successfully.');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, Event $event)
    {
        $request['gallery_images'] = isset($request->gallery_images) && $request->gallery_images != null ? json_decode($request->gallery_images) : null;
        $validationRule = [
            'id' => ['required', 'exists:events,id'],
            'zipcode' => ['nullable'],
            'featured' => 'nullable|boolean',
            'gallery_images' => ['required', 'array'],
            'start_date' => ['required', 'date'],
            // 'end_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'event_website' => ['required', new ValidUrl()],
            'exibitors_url' => ['nullable', new ValidUrl()],
            'visitors_url' => ['nullable', new ValidUrl()],
            'press_url' => ['nullable', new ValidUrl()],
            'video_url' => ['nullable', new ValidUrl()],
            'facebook_url' => ['nullable', new ValidUrl()],
            'twitter_url' => ['nullable', new ValidUrl()],
            'linkedin_url' => ['nullable', new ValidUrl()],
            'youtube_url' => ['nullable', new ValidUrl()],
            'pintrest_url' => ['nullable', new ValidUrl()],
            'instagram_url' => ['nullable', new ValidUrl()],
            'snapchat_url' => ['nullable', new ValidUrl()],
            'contacts.*.name' => 'required|string|max:255',
            'contacts.*.email' => 'required|email|max:255',
            'contacts.*.phone' => 'required|string|max:20',
            // 'contacts.*.designation' => 'required|string|max:255',
            // 'contacts.*.image_path' => 'required|string|max:255',
            'contacts.*.image_path' => 'nullable|string|max:255',
            'customer_id' => ['nullable', 'exists:customers,id'],
        ];
        $errorMessages = [];
        $niceNames = [
            'contacts.*.name' => 'name',
            'contacts.*.email' => 'email',
            'contacts.*.phone' => 'phone',
            // 'contacts.*.designation' => 'designation',
            'contacts.*.image_path' => 'profile image',
        ];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['title.title_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $errorMessages = array_merge($errorMessages, ['title.title_' . $language->id . '.required' => 'Title in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['country.country_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $errorMessages = array_merge($errorMessages, ['country.country_' . $language->id . '.required' => 'Country in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['city.city_' . $language->id => [$requiredVal, 'string', 'max:255']]);
            $errorMessages = array_merge($errorMessages, ['city.city_' . $language->id . '.required' => 'City in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['street_name.street_name_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['street_name.street_name_' . $language->id . '.required' => 'Street name in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['venue.venue_' . $language->id => ['nullable', 'string', 'max:255']]);
            $errorMessages = array_merge($errorMessages, ['venue.venue_' . $language->id . '.required' => 'Venue in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['product_search.product_search_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['product_search.product_search_' . $language->id . '.required' => 'Product search in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['short_description.short_description_' . $language->id => [$requiredVal, 'string', 'maxwords:30']]);
            $errorMessages = array_merge($errorMessages, ['short_description.short_description_' . $language->id . '.required' => 'Short description in ' . $language->name . ' is required.']);
            $errorMessages = array_merge($errorMessages, ['short_description.short_description_' . $language->id . '.maxwords' => 'Short description in ' . $language->name . ' must have less than 30 words.']);

            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string', 'maxwords:3000']]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'Description in ' . $language->name . ' is required.']);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.maxwords' => 'Description in ' . $language->name . ' must have less than 3000 words.']);
        }

        $this->validate($request, $validationRule, $errorMessages, $niceNames);
        $event = Event::whereId($request->id)->with('eventMedia')->first();
        $mediaId = $event->media_id;
        if (isset($request->gallery_images)) {
            $oldMediaPath = [];
            $oldMediaIds = [];
            if (isset($event->eventMedia)) {
                foreach ($event->eventMedia as $key => $eventMedia) {
                    if (isset($eventMedia->media)) {
                        $oldMediaPath[] = $eventMedia->media->path;
                        if (in_array($eventMedia->media->path, $request->gallery_images)) {
                            $oldMediaIds[] = $eventMedia->media->id;
                        }
                    }
                }
            }
            $newMedia = array_merge(array_diff($request->gallery_images, $oldMediaPath), array_diff($oldMediaPath, $request->gallery_images));
            $galleryImages = [];
            if ($newMedia) {
                $galleryImages = $this->moveFile($newMedia, 'media/events', 'events');
                if (isset($galleryImages[0]) && empty($oldMediaIds)) {
                    $mediaId = isset($galleryImages, $galleryImages[0]) ? $galleryImages[0]->id : null;
                } else if (isset($oldMediaIds[0])) {
                    $mediaId = $oldMediaIds[0];
                }
            }
        }
        EventMedia::whereNotIn('media_id', $oldMediaIds)->whereEventId($event->id)->delete();

        $currentRouteName = \Request::route()->getName();
        $customerId = null;
        if ($currentRouteName == 'web.events.store') {
            $customerId = Auth::guard('customers')->user()->id;
        }

        foreach ($languages as $language) {
            if ($language->is_default == '1') {
                $requiredVal = 'required';
                $slug = $request['title']['title_' . $language->id] ?? null;
            }
        }

        $updateData = [
            'zipcode' => $request->zipcode,
            'featured' => $request->featured ?? false,
            'media_id' => $mediaId,
            'slug' => $this->generateUniqueSlug($slug),
            'start_date' => $request->start_date,
            // 'end_date' => $request->end_date,
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'event_website' => $request->event_website,
            'exibitors_url' => $request->exibitors_url,
            'visitors_url' => $request->visitors_url,
            'press_url' => $request->press_url,
            'video_url' => $request->video_url,
            'facebook_url' => $request->facebook_url,
            'twitter_url' => $request->twitter_url,
            'linkedin_url' => $request->linkedin_url,
            'youtube_url' => $request->youtube_url,
            'pintrest_url' => $request->pintrest_url,
            'instagram_url' => $request->instagram_url,
            'snapchat_url' => $request->snapchat_url,
        ];

        // Only update customer_id if it is provided in the request
        if ($request->has('customer_id')) {
            $updateData['customer_id'] = $request->customer_id;
        }

        Event::whereId($request->id)->update($updateData);
        if ($event) {
            if (isset($galleryImages)) {
                // EventMedia::whereEventId($event->id)->delete();
                foreach ($galleryImages as $key => $file) {
                    EventMedia::create([
                        'event_id' => $event->id,
                        'media_id' => $file->id,
                    ]);
                }
            }
            foreach ($languages as $language) {
                $eventDetail = EventDetail::whereEventId($event->id)->whereLanguageId($language->id)->exists();
                if ($eventDetail) {
                    EventDetail::whereEventId($event->id)->whereLanguageId($language->id)->update([
                        'title' => $request['title']['title_' . $language->id] ?? null,
                        'country' => $request['country']['country_' . $language->id] ?? null,
                        'city' => $request['city']['city_' . $language->id] ?? null,
                        'street_name' => $request['street_name']['street_name_' . $language->id] ?? null,
                        'venue' => $request['venue']['venue_' . $language->id] ?? null,
                        'product_search' => $request['product_search']['product_search_' . $language->id] ?? null,
                        'short_description' => $request['short_description']['short_description_' . $language->id] ?? null,
                        'description' => $request['description']['description_' . $language->id] ?? null,
                    ]);
                } else {
                    EventDetail::create([
                        'event_id' => $event->id,
                        'language_id' => $language->id,
                        'title' => $request['title']['title_' . $language->id] ?? null,
                        'country' => $request['country']['country_' . $language->id] ?? null,
                        'city' => $request['city']['city_' . $language->id] ?? null,
                        'street_name' => $request['street_name']['street_name_' . $language->id] ?? null,
                        'venue' => $request['venue']['venue_' . $language->id] ?? null,
                        'product_search' => $request['product_search']['product_search_' . $language->id] ?? null,
                        'short_description' => $request['short_description']['short_description_' . $language->id] ?? null,
                        'description' => $request['description']['description_' . $language->id] ?? null,
                    ]);
                }
            }
            $contacts = $request->input('contacts');
            EventContact::whereEventId($event->id)->delete();

            foreach ($contacts as $contactData) {
                $contact = [
                    'event_id' => $event->id,
                    'name' => $contactData['name'],
                    'email' => $contactData['email'],
                    'phone' => $contactData['phone'],
                    // 'designation' => $contactData['designation'],
                    'image_path' => $contactData['image_path'],
                ];
                if (isset($contactData['id'])) {
                    EventContact::whereId($contactData['id'])->update($contact);
                } else {
                    EventContact::create($contact);
                }
            }
            return $this->apiSuccessResponse(new EventResource($event), 'Event has been updated successfully.');
        }
        return $this->errorResponse();
    }


    public function destroy(Request $request, Event $event)
    {
        if ($event->delete()) {
            return $this->apiSuccessResponse(new EventResource($event), 'Event has been deleted successfully.');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($events)
    {
        $defaultLang = getDefaultLanguage();
        $events = $events->with(['eventDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['withEventDetail']) && $_GET['withEventDetail'] == '1') {
            $events = $events->with('eventDetail');
        }
        if (isset($_GET['withEventContacts']) && $_GET['withEventContacts'] == '1') {
            $events = $events->with('eventContacts');
        }

        if (isset($_GET['withMedia']) && $_GET['withMedia'] == '1') {
            $events = $events->with('media');
        }
        return $events;
    }

    protected function sortingAndLimit($events)
    {
        if (isset($_GET['getAll']) && $_GET['getAll'] == '1') {
            return $events->orderBy('is_default', 'desc')->orderBy('name', 'asc')->get();
        }

        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'native_name', 'event_title'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $events = $events->addSelect(['event_title' => EventDetail::whereColumn('events.id', 'event_detail.event_id')->whereLanguageId($defaultLang->id)->select('title')->limit(1)]);

            $events = $events->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }


        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }
        $events = $events->paginate($limit);

        $currentRouteName = \Request::route()->getName();
        if ($currentRouteName == 'web.events.index') {
            $defaultLang = getDefaultLanguage();
            foreach ($events as $key => $event) {
                $event->show_page = route('user.event.show', ['abbreviation' => $defaultLang->abbreviation, 'id' => $event->id]);
            }
        }
        return $events;
    }

    protected function whereClause($events)
    {
        $currentRouteName = \Request::route()->getName();
        if ($currentRouteName == 'web.events.index') {
            $events = $events->where('customer_id', Auth::guard('customers')->user()->id);
        }
        $defaultLang = getDefaultLanguage(0);
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $events = $events->whereHas('eventDetail', function ($q) use ($defaultLang) {
                $q->whereLanguageId($defaultLang->id)->where(function ($q1) {
                    $q1->where('title', 'LIKE', '%' . $_GET['searchParam'] . '%');
                });
            });
        }
        return $events;
    }

    protected function generateUniqueSlug($initialSlug): string
    {
        $slug = Str::slug($initialSlug);
        $count = 1;

        while (Event::where('slug', $slug)->exists()) {
            $slug = Str::slug($initialSlug . '-' . $count);
            $count++;
        }

        return $slug;
    }
}
